<div class="container py-3">
    <form action="login.php" method="POST">
         <h2 class="text-center pb-5">Login</h2>
        {if isset($error)} <!-- Check if an error message exists -->
            <h4 class="text-danger">{$error}</h4> <!-- Display error message -->
        {/if}
        <div class="row">
            <div class="col-12">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" required class="form-control">
            </div>
            <div class="col-12">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" id="password" required class="form-control">
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary mt-3" type="submit">Login</button>
        </div>
    </form>
</div>