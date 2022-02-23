<div id="upcoming_events">
  <div
    class="upcoming-events"
  >
    <div class="d-flex justify-content-between mb-3">
      <div>
        <h2>Upcoming Events</h2>
        <p class="section-title-bar"></p>
        <p style="font-size: 12px;">Scroll right to view more</p>
      </div>
    </div>

    <div class="carousel-inner">
      <div class="">
        <div class="d-flex carousel-qui-inner" style="overflow-x: scroll;">
          <?php
            require_once "./scripts/db_conn.php";

            $sql = "SELECT events.*, venues.name as venue_name FROM events INNER JOIN venues ON events.venue_id=venues.id ORDER BY events.id DESC";
            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                  while($row = $result->fetch_array()){
                  ?>
              <div class="col-md-4 mb-3" style="margin-right: 16px;">
                <div class="card" style="border-radius: 16px">
                  <img
                    class="img-fluid"
                    style="
                      border-top-left-radius: 16px;
                      border-top-right-radius: 16px;
                    "
                    alt="100%x280"
                    src="/assets/img/uploads/<?php echo $row['banner']?>"
                  />
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $row['name']; ?></h4>
                    <p class="card-subtitle"><?php echo $row['venue_name']; ?></p>
                    <p class="card-text"><?php echo $row['description']; ?></p>
                    <p class="card-price"><small><?php echo ($row['payment_type']  == 1 ? 'Free' : 'Ksh '.number_format($row['amount'],2))?></small></p>

                    <div>
                      <button class="btn btn-primary">Reserve</button>
                    </div>
                  </div>
                </div>
              </div>
          <?php }}} ?>
        </div>
      </div>
    </div>
  </div>
</div>