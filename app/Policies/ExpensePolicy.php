<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Auth\Access\Response;

class ExpensePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return !is_null($user->email_verified_at);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Expense $expense): Response
    {
        return $user->id === $expense->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Expense $expense): Response
    {
        return $this->view($user, $expense);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Expense $expense): Response
    {
        return $this->view($user, $expense);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Expense $expense): Response
    {
        return $this->view($user, $expense);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Expense $expense): Response
    {
        return $this->view($user, $expense);
    }
}
