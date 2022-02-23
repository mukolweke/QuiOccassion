<?php 
require_once "./scripts/db_conn.php";
?>

<div class="contacts" id="contacts">
  <div class="contacts-wrapper">
    <div class="contact-details">
      <h2 class="mb-3">Get a quote</h2>
      <p class="section-title-bar" style="width: 35%;"></p>
      <p class="mb-5">Fill up the form and our Team will get back to you with 24 hours.</p>

      <div class="mb-5" style="width: 280px;">
        <?php 
          $result = $mysqli->query("SELECT * FROM settings WHERE setting_type=1");
          while($row = $result->fetch_array()){
        ?>
          <div class="contact-item">
            <p class="p-0 m-0"><span class="icon"><i class="<?php echo $row['icon']; ?>"></i></span> <span>
              <?php echo $row['value']; ?>
            </span></p>
          </div>
        <?php }?>
      </div>

      <div class="d-flex align-items-center justify-content-between social-links">
        <?php 
          $result = $mysqli->query("SELECT * FROM settings WHERE setting_type=2");
          while($row = $result->fetch_array()){
        ?>
          <p class="m-0 p-0 social-link"><a href="<?php echo $row['value'];?>"><i class="<?php echo $row['icon'];?>"></i></a></p>
        <?php }?>
      </div>
    </div>

    <div class="contacts-form">
      <form class="contact-form">
        <div class="mb-4 form-floating">
          <input type="text" class="form-control" placeholder="Enter Full Name" id="floatingFullName">
          <label for="floatingFullName">Your Name</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="floatingInput" placeholder="Enter Email">
          <label for="floatingInput">Your Email</label>
        </div>
        <div class="form-floating mb-5">
          <textarea class="form-control" placeholder="Enter your comments here" id="floatingTextarea" style="height: 150px"></textarea>
          <label for="floatingTextarea">Comments</label>
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-primary btn-auth">
            Send Message <i class="far fa-paper-plane"></i>
          </button>
        </div>

      </form>
    </div>
  </div>
</div>