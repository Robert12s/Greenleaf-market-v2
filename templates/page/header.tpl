<head>
  <title>Greenleaf Market</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico">
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- main CSS file -->
  <link rel="stylesheet" href="/assets/css/main.css">
  <!-- responsive CSS file -->
  <link rel="stylesheet" href="/assets/css/responsive.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-secondary">
  <nav class="navbar navbar-expand-lg bg-accent py-3">
    <div class="container">
      <a class="navbar-brand" href="/">
          <img src="/assets/img/logo-dark.png" alt="Greenleaf Market Logo" height="80" class="d-inline-block align-text-top">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <form class="d-flex mx-auto w-50" role="search">
            <input class="form-control me-2 rounded-0" type="search" placeholder="Search..." aria-label="Search">
            <button class="btn btn-primary rounded-0" type="submit">Search</button>
        </form>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="/login">
                    <i class="fa-solid fa-user fa-xl" style="color: black;"></i>
                    <h5 class="d-inline ps-3">
                      {if isset($smarty.session.user)}
                        {$smarty.session.user.username}
                      {else}
                        Login
                      {/if}
                    </h5>
                </a>
            </li>
        </ul>
      </div>
    </div>
  </nav>

    <!-- message alerts-->
    {if isset($session.message)}
        <div class="pt-3">
            <div class="alert alert-success">
                {$session.message}
            </div>
            {assign var="session.message" value=null} <!-- Clear the message -->
        </div>
    {/if}

    {if isset($session.error)}
        <div class="pt-3">
            <div class="alert alert-danger">
                {$session.error}
            </div>
            {assign var="session.error" value=null} <!-- Clear the error -->
        </div>
    {/if}

<!-- Bootstrap JS and Popper.js-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>