<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <title>Qui Occasions</title>

    <!-- Icons -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- Styles -->
    <!-- Bootsrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Custom -->
    <link href="/assets/css/main.css" rel="stylesheet" />
    <link href="/assets/css/dash.css" rel="stylesheet" />
  </head>
  <body>
    <?php include 'topbar.php' ?>
    <div class="d-flex">
        <?php include 'navbar.php' ?>

        <main class="dash-main-wrapper" >
            <?php $page = isset($_GET['page']) ? $_GET['page'] :'home'; ?>
            <?php include $page.'.php' ?>
        </main>
    </div>


    <!-- Template Main JS File -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
