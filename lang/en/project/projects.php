<?php

return [
    'project' => [
        'title' => 'Projects',
        'new' => 'New Project',
        'table' => [
            'title' => 'My Projects',
            'empty' => 'No projects found.',
            'add' => 'New Project',
            'headers' => [
                'title' => 'Name',
                'created_by' => 'Created by',
                'status' => 'Status',
                'completion' => 'Completion',
                'options' => 'Options',
            ],
        ],
        'modal' => [
            'delete' => [
                'title' => 'Delete Project',
                'content' => 'Are you sure you want to delete this project? This action cannot be undone. You will lose all data associated with this project.',
                'close' => 'Close',
                'confirm' => 'Confirm',
            ],
        ],
        'options' => [
            'options' => 'Options',
            'delete' => 'Delete',
            'edit' => 'Edit',
            'view' => 'Open',
            'add_member' => 'Team',
            'open_project' => 'Open Project',
        ],
    ],

    'errors' => [
        'email_required' => 'The email field is required.',
        'email_invalid' => 'Please enter a valid email address.',
        'level_required' => 'You must select an access level.',
        'level_integer' => 'The level format is invalid.',
        'level_between' => 'The level must be between 2 and 4.',
    ],


    'email' => [
        'greeting' => 'Hello :name,',
        'invited' => 'You have been invited to join the project: :project',
        'accept_button' => 'Accept Invitation',
        'register_button' => 'Create account and join project',
        'decline_text' => 'If you do not wish to participate, you can <a href=":url">decline the invitation</a>.',
        'regards' => 'Regards',
        'subcopy' => "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser:",
        'subject_invitation' => 'Thoth SLR :: Invitation to join the project: :project',
    ],

    'no_access_project' => 'You do not have permission to access this project.',
    'no_permission_edit' => 'You do not have permission to edit this project.',
    'no_permission_delete' => 'You do not have permission to delete this project.',
    'no_permission_remove_member' => 'You do not have permission to remove members from this project.',
    'no_permission_add_member' => 'You do not have permission to add members to this project.',
    'no_permission_update_level' => 'You do not have permission to update the member\'s level.',
    'no_permission_resend' => 'You do not have permission to resend the invitation.',

    'user_already_in_project' => 'The user is already associated with the project.',
    'member_not_found' => 'Member not found.',

    'invite_sent' => 'Invitation sent to :email',
    'invite_resent' => 'Invitation resent successfully!',
    'invite_already_accepted' => 'This user already accepted the invitation.',
    'invite_invalid' => 'Invalid or expired invitation.',
    'invite_accepted' => 'You have successfully joined the project!',

    'level_updated' => 'Member level updated successfully.',

    'activity_created' => 'Project :title created successfully.',
    'activity_updated' => 'Project updated.',
    'activity_deleted' => 'Project :title deleted.',
    'activity_member_removed' => 'The admin removed :user from the project :title.',
    'activity_level_updated' => 'The admin updated :user level to :level.',
    'activity_invite_sent' => 'Invitation sent to :user to join the project :title.',
    'activity_invite_accepted' => 'Invitation accepted to join the project.',

    // Guest user created
    'guest_user_created' => 'A guest user account was created for :email.',
    'guest_invite_success' => 'Invitation sent to invited user :email.',
    'must_register_first' => 'To access this invitation, you must complete your registration first.',

    // Success accepting invite
    'invitation_accepted' => 'Invitation successfully accepted! Welcome to the project.',
    'invitation_declined' => 'You declined the invitation to join the project.',
];
