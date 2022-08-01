<div class="col d-lg-block d-none p-all-0 text-white  mail-sidebar">
    <div class="usable-height panel">
        <div class="panel-header p-all-15 mail-sidebar-header">
            <div class="media">
                <div class="d-inline-block m-r-10 align-middle">
                    <div class="avatar avatar">
                        <span class="avatar-title rounded-circle  bg-white-translucent"> A </span>
                    </div>
                </div>
                <div class="media-body my-auto">
                    <p class="font-secondary m-b-0"><?php echo $_SESSION['user']['name'];?></p>
                </div>
            </div>        
        </div>
        <div class=".panel-body p-t-10  border-white">
            <div class="p-all-15">
                <a href="#" class="btn btn-success btn-block js-compose-toggle">Compose</a>
            </div>
            <a href="feedback.php" class=" mail-sidebar-item active btn-ghost">
                <div class="w-100 text-truncate">
                    Inbox
                </div>
            </a>
            <a href="feedback.php?sent" class=" mail-sidebar-item btn-ghost">
                <div class="w-100 text-truncate">
                    Sent
                </div>
            </a>
        </div>
    </div>
</div>