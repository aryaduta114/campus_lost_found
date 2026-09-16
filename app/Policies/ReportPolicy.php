<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    /**
     * Determine whether the user can update the report.
     */
    public function update(User $user, Report $report): bool
    {
        return $user->id === $report->user_id;
    }

    /**
     * Determine whether the user can delete the report.
     */
    public function delete(User $user, Report $report): bool
    {
        return $user->id === $report->user_id;
    }
}