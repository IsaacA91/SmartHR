@extends('layouts.adminHeader')

@section('title', 'Employee Directory')

@section('content')
<style>
    :root {
        --primary-blue: #4849E8;
        --light-blue: #ABC4FF;
        --neon-yellow: #DDF344;
        --white: #F5F9FF;
        --card-shadow: 0 8px 16px rgba(72, 73, 232, 0.1);
    }

    body {
        background-color: var(--white);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--primary-blue);
    }

    .employee-table-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 2rem;
        background-color: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(72, 73, 232, 0.1);
    }

    .employee-table-container h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
        border-bottom: 4px solid var(--primary-blue);
        padding-bottom: 0.5rem;
    }

    table.employee-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 15px;
    }

    table.employee-table th {
        background-color: var(--light-blue);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--primary-blue);
        border-radius: 8px 8px 0 0;
    }

    table.employee-table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        color: #333;
    }

    table.employee-table tr:nth-child(even) {
        background-color: #f0f4ff;
    }

    table.employee-table tr:hover {
        background-color: #e6f0ff;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #777;
    }

    .pagination-wrapper {
        text-align: center;
        margin-top: 20px;
    }

    .pagination-wrapper .pagination {
        display: inline-flex;
        gap: 6px;
    }

    .pagination-wrapper .pagination li {
        display: inline;
    }

    .pagination-wrapper .pagination li a,
    .pagination-wrapper .pagination li span {
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 600;
    }

    .pagination-wrapper .pagination li.active span {
        background-color: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }
    button {
        padding: 8px 16px;
        border: 2px solid var(--primary-blue);
        border-radius: 6px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 600;
        background-color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    button:hover {
        background-color: var(--primary-blue);
        color: white;
    }
    
    .btn-edit {
        background-color: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
        margin-right: 5px;
    }
    
    .btn-edit:hover {
        background-color: #3637b8;
        border-color: #3637b8;
    }
    
    .btn-terminate {
        background-color: white;
        color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-terminate:hover {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    
    .search-container {
        margin-bottom: 1.5rem;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    
    .search-container input {
        flex: 1;
        padding: 10px 15px;
        border: 2px solid var(--light-blue);
        border-radius: 8px;
        font-size: 1rem;
        color: var(--primary-blue);
    }
    
    .search-container input:focus {
        outline: none;
        border-color: var(--primary-blue);
    }
    
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid var(--light-blue);
        border-top: none;
        border-radius: 0 0 8px 8px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: none;
    }
    
    .search-suggestions.active {
        display: block;
    }
    
    .suggestion-item {
        padding: 12px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f0f4ff;
        transition: background-color 0.2s;
    }
    
    .suggestion-item:hover {
        background-color: #e6f0ff;
    }
    
    .suggestion-item:last-child {
        border-bottom: none;
    }
    
    .suggestion-highlight {
        font-weight: 700;
        color: var(--primary-blue);
    }
    
    .suggestion-details {
        font-size: 0.85rem;
        color: #666;
        margin-top: 2px;
    }
    
    .search-container button {
        padding: 10px 20px;
    }
    
    @media (max-width: 768px) {
        table.employee-table {
            display: block;
            overflow-x: auto;
        }
        
        .search-container {
            flex-direction: column;
        }
        
        .search-container input {
            width: 100%;
        }
    }
</style>

<div class="employee-table-container">
    <h2>Employee Directory</h2>
    
    <div class="search-container">
        <form method="GET" action="{{ route('admin.employeeList') }}" style="display: flex; gap: 10px; width: 100%; position: relative;">
            <div style="flex: 1; position: relative;">
                <input 
                    type="text" 
                    id="searchInput"
                    name="search" 
                    placeholder="Search by name, email, employee ID, or department..." 
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
                <div id="searchSuggestions" class="search-suggestions"></div>
            </div>
            <button type="submit">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.employeeList') }}"><button type="button">Clear</button></a>
            @endif
        </form>
    </div>
    
    <form style='justify-self:center; margin-bottom:15px;' method='get' action="{{ route('admin.employee.form') }}">
        @csrf
        <button> Add Employee </button>
    </form>
    @if ($employees->count())
        <table class="employee-table">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Joined On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $index => $employee)
                    <tr>
                        <td>{{ $employee->employeeID }}</td>
                        <td>{{ $employee->firstName }} {{ $employee->lastName }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->department->departmentName ?? '—' }}</td>
                        <td>{{ $employee->position ?? '—' }}</td>
                        <td>{{ $employee->baseSalary }}</td>
                        <td>{{ \Carbon\Carbon::parse($employee->created_at)->format('M d, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.editForm', $employee->employeeID) }}">
                                    <button class="btn-edit">Edit</button>
                                </a>
                                <a href="{{ route('admin.remove.employee', $employee->employeeID) }}">
                                    <button class="btn-terminate">Terminate</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper">
            {{ $employees->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="no-data">No employees found.</div>
    @endif
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchSuggestions = document.getElementById('searchSuggestions');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            searchSuggestions.classList.remove('active');
            searchSuggestions.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('admin.employeeList') }}?search=${encodeURIComponent(query)}&ajax=1`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let html = '';
                    data.forEach(employee => {
                        const regex = new RegExp(`(${query})`, 'gi');
                        const name = `${employee.firstName} ${employee.lastName}`;
                        const highlightedName = name.replace(regex, '<span class="suggestion-highlight">$1</span>');
                        const highlightedID = employee.employeeID.replace(regex, '<span class="suggestion-highlight">$1</span>');
                        const highlightedEmail = employee.email.replace(regex, '<span class="suggestion-highlight">$1</span>');
                        
                        html += `
                            <div class="suggestion-item" onclick="selectEmployee('${employee.employeeID}', '${name}')">
                                <div>${highlightedID} - ${highlightedName}</div>
                                <div class="suggestion-details">${highlightedEmail} • ${employee.department || '—'}</div>
                            </div>
                        `;
                    });
                    searchSuggestions.innerHTML = html;
                    searchSuggestions.classList.add('active');
                } else {
                    searchSuggestions.classList.remove('active');
                    searchSuggestions.innerHTML = '';
                }
            })
            .catch(error => {
                console.error('Error fetching suggestions:', error);
            });
        }, 300);
    });

    function selectEmployee(employeeID, name) {
        searchInput.value = employeeID;
        searchSuggestions.classList.remove('active');
        searchSuggestions.innerHTML = '';
        searchInput.form.submit();
    }

    // Close suggestions when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !searchSuggestions.contains(event.target)) {
            searchSuggestions.classList.remove('active');
        }
    });
</script>
@endsection