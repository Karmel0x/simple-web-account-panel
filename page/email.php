<?php
return; // not implemented

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login");
    exit();
}
?>

<div class="column grid-cell grid-cell-3-4">
    <form action="./email" method="post">
        <div class="column-body grid">
            <div class="grid-cell grid-cell-2-3">
                <div class=" form-group">
                    <label class="form-group-label">CURRENT EMAIL</label>
                    <div class="form-group-contents"><span><?php echo $result['email']; ?></span></div>
                </div>
                <hr>
                <div class=" form-group">
                    <label class="form-group-label">NEW EMAIL ADDRESS</label>
                    <input class="form-input form-control" type="email" name="reg_email" onchange="mailCheck();">
                </div>
                <div class=" form-group">
                    <label class="form-group-label">CONFIRM NEW EMAIL ADDRESS</label>
                    <input class="form-input form-control" type="email" name="reg_email2" onchange="mail2Check();">
                </div>
                <div class="input-feedback help-panel-body">
                    <p class="unsatisfied" id="mailvalid">Email address have to be valid.</p>
                    <p class="unsatisfied" id="mailmatch">Email addresses must match.</p>
                </div>
            </div>
            <script src="./assets/email.js" type="text/javascript"></script>
            <div class="grid-cell grid-cell-1-3">
                <div class="help-panel">
                    <h3>HEADS UP</h3>
                    <p class="help-panel-body">Before we update your email, we'll send a confirmation email to your new address. Click the link inside that email to finish the update.</p>
                </div>
            </div>
        </div>
        <div class="column-footer grid">
            <div class="grid-cell">
                <p class="button">
                    <button class="button-input">Submit</button>
                </p>
                <p class=" button">
                    <a class="button-input" href="./account" style="display:block;text-align:center;text-decoration:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">Cancel</a>
                </p>
            </div>
        </div>
    </form>
</div>