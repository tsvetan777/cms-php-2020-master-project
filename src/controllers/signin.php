<?php

if(isset($_POST['user_request_tokken']) && $_POST['user_request_tokken'] == 1) {
    
    $userEmail      = $_POST['user_email'];
    $userPassword   = $_POST['user_pass'];

    $checkIfUserExistsQuery  = " SELECT * FROM tb_users WHERE "
                             . " email = '$userEmail' AND password = '$userPassword' ";

    $userRecord = Database::get($checkIfUserExistsQuery);
    
    if($userRecord) {
        
        $userRoleId                     = $userRecord['id'];
        $getUserRoleCollectionQuery     = " SELECT b.ttitle AS role_title "
                                        . " FROM tb_user__role AS a, "
                                        . " WHERE user_id = $userRoleId "
                                        . " AND a.role_id = b.id ";
        $userRoleCollection             = Database::getall($getUserRoleCollectionQuery);
        
        Auth::setAuthenticatedUser(array(
            'user_data_collection' => $userRecord,
            'user_role_collection' => $userRoleCollection
        ));
        
        return redirectTo('index');
    }
    
    return setFormError("signin", "user_email", "Login attempt is not successful");
    
}

