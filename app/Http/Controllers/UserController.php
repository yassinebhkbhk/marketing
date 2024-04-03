<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(10);
        return view('users', compact('users'));
    }

    public function activate(User $user)
    {
        $user->update(['status' => 1]);
        return redirect()->back()->with('success', 'User activated successfully');
    }

    public function deactivate(User $user)
    {
        $user->update(['status' => 0]);
        return redirect()->back()->with('success', 'User deactivated successfully');
    }
    public function searchUsers(Request $request)
{
    $searchTerm = $request->get('searchTerm');

    // Query Builder Approach
    $users = User::where('name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%")
                ->paginate(10); // Adjust pagination as needed

    // Alternative: Eloquent Scopes (if applicable)
    // $users = User::search($searchTerm)->paginate(10);

    return view('users', compact('users', 'searchTerm'));
}

public function userChart(Request $request)
{
    // Get the selected year from the request or default to the current year
    $selectedYear = $request->input('year', date('Y'));

    $users = User::selectRaw('MONTH(created_at) as month, count(*) as count')
                    ->whereYear('created_at', $selectedYear)
                    ->groupBy('month')
                    ->get();

    $labels = [];
    $data = [];

    // Define different colors for each month
    $colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF99CC',
        '#FF9933', '#99FF99', '#33CCCC', '#FF6666', '#FF9933', '#339933'
    ];

    // Initialize the data array for all months of the year
    for ($i = 1; $i <= 12; $i++) {
        $monthName = date('F', mktime(0, 0, 0, $i, 1));
        $labels[] = $monthName;
        $data[] = 0;
    }

    // Update the actual data for months with users
    foreach ($users as $user) {
        $monthIndex = $user->month - 1; // Months are zero-indexed
        $data[$monthIndex] = $user->count;
    }

    $datasets = [
        [
            'label' => 'Number of Users',
            'data' => $data,
            'backgroundColor' => $colors
        ]
    ];

    // Pass the datasets, labels, and selected year to the view
    return view('userChart', compact('datasets', 'labels', 'selectedYear'));
}

}
