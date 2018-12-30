  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbConnection.php';
require_once 'userInformationUtility.php';

					$conn = connect();
					$sql = "SELECT * FROM Review ORDER BY RAND() LIMIT 3";
$i=0;
					$result = $conn->query($sql);
						if($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								$i++;
								$sql2 = "SELECT * FROM Users WHERE Email = '".$row["Email"]."'";

								$result2 = $conn->query($sql2);
								if($result2->num_rows > 0) {
									while($row2 = $result2->fetch_assoc()) {
					?>
					
					
					
					
					
					<div id="r<?php echo $i;?>" class="col-md-4 col-sm-6 <?php if($i==2) { echo 'hidden-xs'; } else if($i==3) { echo 'hidden-xs  hidden-sm'; };?>">
        				    <div class="block-text rel zmin">
						        <a title="" href="#"><?php echo $row["Title"]; ?></a>
							    <div class="mark">My rating: 
									<span class="rating-input">
										<?php
										$s = 0;
										while($s < $row["Vote"]) {
											$s++;
											?>
											<span class="glyphicon glyphicon-star"></span>
											<?php
										}
										while($s < 5) {
											$s++;
											?>
											<span class="glyphicon glyphicon-star-empty"></span>
											<?php
										}
										?>
									</span>
								</div>
						        <p><?php echo $row["Description"]; ?></p>
							    <ins class="ab zmin sprite sprite-i-triangle block"></ins>
					        </div>
							<div class="person-text rel">
								<?php echo '<img alt="" height="60" src="' . htmlspecialchars($row2["Photo"]) . '"/>'; ?>
								<p><?php echo $row2["Username"]; ?></p>
							</div>
						</div>

					<?php
									}
								}
							}
						}
					?>
					

					
					
