<div class="container mt-3">

    <h3>Admin Dashboard</h3>
    <hr>

    <!-- Total Users card -->
    <div class="card bg-primary text-white mb-3">
        <div class="card-body">
            <h5 class="card-title">Total Users</h5>
            <h2><?php echo $total_users; ?></h2>
        </div>
    </div>

    <!-- Logged in user card -->
    <div class="card bg-success text-white mb-3">
        <div class="card-body">
            <h5 class="card-title">Logged in as</h5>
            <h2><?php echo $current_user; ?></h2>
        </div>
    </div>

    <!-- Server time -->
    <div class="card bg-warning text-dark mb-3">
        <div class="card-body">
            <h5 class="card-title">Server Time</h5>
            <h2><?php echo date('Y-m-d H:i:s'); ?></h2>
        </div>
    </div>

</div>
