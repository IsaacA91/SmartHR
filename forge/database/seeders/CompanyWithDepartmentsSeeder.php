<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyWithDepartmentsSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Insert company
        $companyID = 'C001';
        DB::table('company')->insert([
            'companyID' => $companyID,
            'companyName' => 'Acme SmartHR',
            'companyOwner' => $faker->name,
        ]);

        // Prepare 5 departments
        $departments = [];
        for ($i = 1; $i <= 5; $i++) {
            $deptId = sprintf('D%03d', $i); // D001..D005
            $departments[] = [
                'departmentID' => $deptId,
                'departmentName' => ucfirst($faker->unique()->word) . ' Department',
                'departmentManager' => $faker->name,
                'departmentLocation' => $faker->city . ', ' . $faker->country,
                'companyID' => $companyID,
            ];
        }

        DB::table('department')->insert($departments);

        // Choose different number of employees per department (between 5 and 15)
        // We'll pick 5 distinct values to guarantee different counts
        $possible = range(5, 15);
        shuffle($possible);
        $counts = array_slice($possible, 0, 5); // e.g. [12,7,9,5,14]

        // Insert employees with unique IDs E001...
        $employeeIndex = 1;
        $employeesToInsert = [];

        foreach ($departments as $index => $dept) {
            $count = $counts[$index];
            for ($j = 0; $j < $count; $j++) {
                $empId = sprintf('E%03d', $employeeIndex); // E001, E002, ...
                $firstName = $faker->firstName;
                $lastName = $faker->lastName;
                $username = strtolower(substr($firstName,0,1) . $lastName) . $employeeIndex;

                $employeesToInsert[] = [
                    'employeeID' => $empId,
                    'companyID' => $companyID,
                    'position' => $faker->jobTitle,
                    'departmentID' => $dept['departmentID'],
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'phone' => preg_replace('/[^0-9]/', '', $faker->phoneNumber),
                    'email' => $username . '@' . strtolower(str_replace(' ', '', $faker->company)) . '.local',
                    'username' => $username,
                    // Hash passwords - ensure your DB password column supports the hash length (VARCHAR(255) recommended)
                    'password' => Hash::make('password123'),
                    'baseSalary' => $faker->randomFloat(2, 20000, 80000),
                    'rate' => $faker->randomFloat(2, 50, 500),
                ];

                $employeeIndex++;
            }
        }

        // Bulk insert employees in chunks to avoid very large single queries
        $chunks = array_chunk($employeesToInsert, 200);
        foreach ($chunks as $chunk) {
            DB::table('employee')->insert($chunk);
        }

        // Output a summary to the console when seeding
        $this->command->info("Inserted company {$companyID} with 5 departments and " . count($employeesToInsert) . " employees (counts: " . implode(', ', $counts) . ")");

        // Now create attendance records, payslips and leave requests for the created employees

        $employees = DB::table('employee')->where('companyID', $companyID)->get();

        $attendanceInserts = [];
        $payslipInserts = [];
        $leaveInserts = [];

        $recordCounter = 1; // for recordID R00001
        $slipCounter = 1;   // for slipID S0001
        $leaveCounter = 1;  // for leaveRecordID L0001

        foreach ($employees as $emp) {
            // Generate attendance for last 30 days
            for ($d = 0; $d < 30; $d++) {
                $date = \Carbon\Carbon::today()->subDays($d)->toDateString();

                // 70% chance the employee worked that day
                if ($faker->boolean(70)) {
                    $timeIn = $faker->time('H:i:s', '09:00:00');
                    // timeOut between 5 and 9 hours later
                    $in = \Carbon\Carbon::createFromFormat('H:i:s', $timeIn);
                    $workHours = $faker->randomFloat(1, 6, 10); // 6.0 - 10.0 hours
                    $timeOut = $in->copy()->addSeconds((int)($workHours * 3600))->format('H:i:s');

                    $recordId = 'R' . str_pad($recordCounter, 5, '0', STR_PAD_LEFT);
                    $attendanceInserts[] = [
                        'recordID' => $recordId,
                        'employeeID' => $emp->employeeID,
                        'workDay' => $date,
                        'hoursWorked' => round($workHours, 1),
                        'timeIn' => $timeIn,
                        'timeOut' => $timeOut,
                    ];
                    $recordCounter++;
                }
            }

            // Create one payslip for the previous month
            $periodBegin = \Carbon\Carbon::now()->subMonth()->startOfMonth()->toDateString();
            $periodEnd = \Carbon\Carbon::now()->subMonth()->endOfMonth()->toDateString();
            $overtime = $faker->randomFloat(1, 0, 12); // 0 - 12 hours
            // estimate total pay: (baseSalary / 12) + overtime * rate
            $baseSalary = floatval($emp->baseSalary);
            $rate = floatval($emp->rate);
            $totalPay = round(($baseSalary / 12) + ($overtime * $rate), 2);
            $slipId = 'S' . str_pad($slipCounter, 4, '0', STR_PAD_LEFT);
            $payslipInserts[] = [
                'slipID' => $slipId,
                'employeeID' => $emp->employeeID,
                'payPeriodBeginning' => $periodBegin,
                'payPeriodEnd' => $periodEnd,
                'overtimeHours' => $overtime,
                'totalPayForPeriod' => $totalPay,
            ];
            $slipCounter++;

            // Create 0-2 leave requests randomly
            $leavesCount = $faker->numberBetween(0, 2);
            for ($l = 0; $l < $leavesCount; $l++) {
                $start = \Carbon\Carbon::today()->subDays($faker->numberBetween(1, 90));
                $end = $start->copy()->addDays($faker->numberBetween(1, 7));
                $approval = $faker->randomElement(['Pending', 'Approved', 'Rejected']);
                $approvedBy = null;
                if ($approval === 'Approved') {
                    // pick a random admin for company if exists
                    $admin = DB::table('admin')->where('companyID', $companyID)->inRandomOrder()->first();
                    $approvedBy = $admin ? $admin->adminID : null;
                }

                $leaveId = 'L' . str_pad($leaveCounter, 4, '0', STR_PAD_LEFT);
                $leaveInserts[] = [
                    'leaveRecordID' => $leaveId,
                    'employeeID' => $emp->employeeID,
                    'startDate' => $start->toDateString(),
                    'endDate' => $end->toDateString(),
                    'approval' => $approval,
                    'approvedBy' => $approvedBy,
                ];
                $leaveCounter++;
            }
        }

        // Insert attendance records in chunks
        foreach (array_chunk($attendanceInserts, 200) as $chunk) {
            DB::table('attendancerecord')->insert($chunk);
        }

        // Insert payslips
        foreach (array_chunk($payslipInserts, 200) as $chunk) {
            DB::table('payslip')->insert($chunk);
        }

        // Insert leave requests
        if (!empty($leaveInserts)) {
            foreach (array_chunk($leaveInserts, 200) as $chunk) {
                DB::table('leaverequests')->insert($chunk);
            }
        }

        $this->command->info('Inserted ' . count($attendanceInserts) . " attendance records, " . count($payslipInserts) . " payslips and " . count($leaveInserts) . " leave requests.");
    }
}
