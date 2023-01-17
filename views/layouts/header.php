<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn bg-custom text-white">
            <i class="fas fa-align-left"></i>
        </button>
        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link text-custom" href="<?php echo BASE_URL.'?q=profile';?>">
                        Account Setting
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link text-custom" onclick="$('#LogoutForm').submit()" href="javascript:void(0)">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<form action="./actions/auth.php" method="post" id="LogoutForm">
    <input type="hidden" name="action" value="logout" />
</form>
