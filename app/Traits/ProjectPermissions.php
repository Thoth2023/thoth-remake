<?php

namespace App\Traits;

trait ProjectPermissions
{
    /**
     * Check if the user has permission to edit.
     * 
     * @return bool
     */
    protected function userCanEdit()
    {
        $user = auth()->user();
        // Check if user is NOT a viewer (level not '2')
        return !$this->currentProject->userHasLevel($user, '2');
    }
    
    /**
     * Check if user has permission and display error toast if not
     * 
     * @param string $toastMessageKey Translation key for the denied message
     * @return bool True if user can edit, false otherwise
     */
    protected function checkEditPermission($toastMessageKey)
    {
        if (!$this->userCanEdit()) {
            $this->toast(
                message: __($toastMessageKey),
                type: 'error'
            );
            return false;
        }
        return true;
    }
}