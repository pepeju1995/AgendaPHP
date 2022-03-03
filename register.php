<?php

  require "db.php";
  
  $error = null;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["name"]) || empty($_POST["password"]) || empty($_POST["email"])){
      $error = "Please fill all the fields.";
    } else if(!str_contains($_POST["email"], "@")) {
      $error = "Email format is incorrect.";
    } else {
      $stmt  = $conn->prepare("SELECT * FROM users WHERE email = :email;");
      $stmt->bindParam(":email", $_POST["email"]);
      $stmt->execute();

      if($stmt->rowCount() > 0){
        $error = "Email already exist.";
      } else {
        $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)")
          ->execute([
            ":name" => $_POST["name"], 
            ":email" => $_POST["email"], 
            ":password" => password_hash($_POST["password"], PASSWORD_BCRYPT)
          ]);

          header("Location: home.php");
      }
    }
  }
?>

<?php require "partials/header.php" ?>
  <div class="container pt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>
          <div class="card-body">
            <?php if($error):?>
              <p class="text-danger">
                <?=$error ?>
              </p>
            <?php endif ?>
            <form method="post" action="register.php">
              <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" autocomplete="email" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" name="password" autocomplete="password" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require "partials/footer.php" ?>
