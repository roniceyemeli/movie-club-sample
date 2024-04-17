<?php

// logout
if (isset($_POST['but_logout'])) {
    session_destroy();
    header('Location: index.php');
}

?>
<div class="admin-section-header">
    <div class="admin-logo">
        EPI Cinema Club
    </div>
    <div class="admin-login-info">
        <form method='post' action="" style='margin-right: 1rem;'>
            <input type="submit" value="Logout" class="btn btn-outline-warning" name="but_logout">
        </form>
    </div>
</div>