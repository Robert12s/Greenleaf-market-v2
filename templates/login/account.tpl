<div class="container py-5">
    {if isset($user)}
        <h2>Welcome, {$user.f_name} {$user.l_name}</h2>
        <p>Email: {$user.email}</p>
        <p>Username: {$user.username}</p>

        <!-- Logout form -->
        <form method="POST" action="logout.php">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    {else}
        <p>No user information available.</p>
    {/if}
</div>