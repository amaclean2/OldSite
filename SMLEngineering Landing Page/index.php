<?php
	include("../connect.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = 'utf-8'>
	<title>SML Engineering</title>
	<link rel = "stylesheet" href = "styleFirst.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<body>
	<div ng-app = "webApp" ng-init = "show = false">
		<!--title position logo on non-mobile screens-->
		<div class = "top">
			<h1 class = "logo-big"><a href = "index.php">SML Engineering Inc.</a></h1>
		</div>
		<!--fixed position elements-->
		<div class = "non-movable">
			<!--nav-bar links-->
			<header>
				<ul>
					<li><a href = "#home">capabilities</a></li>
					<li><a href = "#processes">processes</a></li>
					<li><a href = "#materials">materials</a></li>
					<li><a href = "#industries">industries</a></li>
					<li><a href = "#machines">machines</a></li>
					<li><a href = "#images">gallery</a></li>
					<li><a href = "#contacts">contacts</a></li>
					<div class = "db"><a href = "http://smltoolsdb.com"><i class="fa fa-database" aria-hidden="true"></i> <span class = "icon-text">Login to Database</span></a></div>
				</ul>
				<!-- nav-bar for small-screen devices -->
				<div id = "small-nav">
					<button ng-click = "show = !show"><i class="fa fa-bars" aria-hidden="true" ></i></button>
					<div class = "logo-small">SML Engineering Inc.</div>
				</div>
			</header>
			<div id = "links-list" ng-show = "show">
				<button id = "close-btn" ng-click = "show = false">Close x</button>
				<ul>
					<li><a href = "#home" ng-click = "show = false"><i class="fa fa-wrench" aria-hidden="true"></i><span class = "icon-text">capabilities</span></a></li>
					<li><a href = "#processes" ng-click = "show = false"><i class="fa fa-paint-brush" aria-hidden="true"></i><span class = "icon-text">processes</span></a></li>
					<li><a href = "#materials" ng-click = "show = false"><i class="fa fa-th" aria-hidden="true"></i><span class = "icon-text">materials</span></a></li>
					<li><a href = "#industries" ng-click = "show = false"><i class="fa fa-users" aria-hidden="true"></i><span class = "icon-text">industries</span></a></li>
					<li><a href = "#machines" ng-click = "show = false"><i class="fa fa-cog" aria-hidden="true"></i><span class = "icon-text">machines</span></a></li>
					<li><a href = "#images" ng-click = "show = false"><i class="fa fa-camera-retro" aria-hidden="true"></i><span class = "icon-text">gallery</span></a></li>
					<li><a href = "#contacts" ng-click = "show = false"><i class="fa fa-envelope" aria-hidden="true"></i><span class = "icon-text">contact</span></a></li>
				</ul>
			</div>
			<div class = "certifications">
				<img src = "AS9100-logo.jpg" alt = "AS9100 Certified" id = "AS-logo" class = "certs" />
				<img src = "ISO-Certified.png" alt = "ISO Cerfitied" id = "ISO-logo" class = "certs" />
				<img src = "ISA-logo2.jpg" alt = "ISA Certified" id = "ISA-logo" class = "certs" />
			</div>
		</div>
		<div class = "front">
			<div class = "motto-small">
				<h2>Precision machining since 1976 - Your source when quality is critical</h2>
				<div class = "button-small">
					<a href = "#quote-tab"><i class="fa fa-quote-left" aria-hidden="true"></i><span class = "icon-text">Request A Quote</span></a>
					<a href = "http://smltoolsdb.com" id = "db-small"><i class="fa fa-database" aria-hidden="true"></i> <span class = "icon-text">Login to Database</span></a>
				</div>
			</div>
		</div>
		<div class = "wrapper">
			<div id = "home">
				<h2 id = "home-tag"><i class="fa fa-wrench" aria-hidden="true"></i><span class = "icon-text">Machince shop capabilities</span></h2>
				<div class = "split-div uneven-small">
					<img src = "partImage.png" alt = "Mill Parts" id = "cap-part"/>
				</div>
				<div class = "split-div uneven">
					<div class = "info home">
							<ul>
								<li>
									A full production, precision CNC machining source
								</li>
								<li>
									Support for manufacturing from prototype to medium scale production
								</li>
								<li class = "btn">
									<span class = "bullet">1</span>
									Manufacturing of machined parts from raw bar stock, and castings or forgings...
									<span id = "hide">, including milling, turning and assembly, as well as non-destructive testing and plating to various specifications as required.</span>
								</li>
								<li>
									Complex machining and fixture design and fabrication
								</li>
								<li>
									Full certification on materials and processes, to aerospace standards
								</li>
							</ul>
					</div>
				</div>
			</div>
			<div id = "processes">
				<h2 id = "home-tag"><i class="fa fa-paint-brush" aria-hidden="true"></i><span class = "icon-text">Plating and Testing Processes</span></h2>
				<div class = "split-div uneven">
					<div class = "info plating">
						<ul>
							<li class = "dropdown">Heat Treating as Required</li>
							<li class = "dropdown"><span class = "bullet">1</span>Non destructive testing:
								<ul class = "dropdown-content">
									<li>Magnetic particle inspection</li>
									<li>Liquid penetrant inspection</li>
									<li>Nital Etch</li>
								</ul></li>
							<li class = "dropdown"><span class = "bullet">1</span>Parts plating:
								<ul class = "dropdown-content">
									<li>Anodize</li>
									<li>Electroless-Nickel Plating</li>
									<li>Chrome Plating</li>
									<li>Cadmium Plating</li>
									<li>Paint</li>
									<li>Passivation, Electro-polish, etc...</li>
								</ul></li>
							<li class = "dropdown"><span class = "bullet">1</span>Part Identification:
								<ul class = "dropdown-content">
									<li>Electro-chemichal etch</li>
									<li>Laser engrave</li>
									<li>Silkscreen</li>
									<li>Ink stamp</li>
									<li>Machine engraving</li>
								</ul></li>
							<li>In-house precision deburring</li>
							<li class = "dropdown"><span class = "bullet">1</span>Component assembly including installation
								<ul class = "dropdown-content">
									<li>Pins</li>
									<li>Heli-Coils</li>
									<li>Lee Jets</li>
									<li>Rivets</li>
									<li>Ball Bearing Swaging/Staking</li>
									<li>Electron Beam and Induction Welding</li>
								</ul></li>
							<li class = "dropdown">Ultrasonic part cleaning</li>
							<li class = "dropdown">Application of corrosion protection oil</li>
							<li class = "dropdown">Labeling and packaging per customer requirements</li>
						</ul>
					</div>
				</div>
				<div class = "split-div uneven-small">
					<img src = "platingImage.png" alt = "plating" id = "cap-part2" />
				</div>
			</div>
			<div id = "materials">
				<h2 id = "materials-tag"><i class="fa fa-th" aria-hidden="true"></i><span class = "icon-text">Materials</span></h2>
				<div class = "split-div uneven">
					<div class = "info plating">
						<ul>
							<li>Stainless steels: 300, 400 Series, PH Grade: 15-5, 17-4, 18-8, 13-8 and 440 C high hardening</li>
							<li>Low Alloy Aircraft Steels: 4130, 4340, 4140, 52100</li>
							<li>Carbon Steels: 1018, 1144, 1117, 1215, 12L14</li>
							<li>Tool Steels</li>
							<li>Aluminum: 2024, 6061, 7075, 2219, etc..., in many tempers</li>
							<li>Brass and bearing bronzes</li>
							<li>Titanium: either 6 AL-4V, commercially or other alloys</li>
							<li>Unusal Materials such as Beryllium Copper, Carpenter Electric Iron, Molybdenum, Tungsten, Bi-metalic sprint stock, etc</li>
							<li>Exotics: Inconel, Waspalloy, Hasteloy, Monel, Nitronic, etc...</li>
							<li>Plastic: Nylon, Delrin, Torlon, PTFE, etc...</li>
							<li>Others as required</li>
						</ul>
					</div>
				</div>
			</div>
			<div id = "industries">
				<h2 id = "industries-tag"><i class="fa fa-users" aria-hidden="true"></i><span class = "icon-text">Industries and Customers</span></h2>
				<div class = "info industries">
					<div class = "split-div">
						<h3>Industries</h3>
						<ul>
							<li>Aerospace, Aviation, Defense</li>
							<li>Industrial Telecommunications and Micro-electronics</li>
							<li>Medical/Healthcare</li>
							<li>Marine</li>
							<li>Automotive, Motorsport, Transportation</li>
							<li>Test And Measurement</li>
						</ul>
					</div>
					<div class = "split-div">
						<h3>Customers Certified For</h3>
						<ul>
							<li>Parker Control Systems Div.</li>
							<li>Parker Hydraulics Systems Div.</li>
							<li>Parker Racor (Water Filtration)</li>
							<li>Parker Veriflo (valve and regulator)</li>
							<li>Circor Aerospace</li>
							<li>Senior Aerospace</li>
							<li>General Atomics Aeronautical</li>
							<li>Nabtesco Aerospace</li>
							<li>ITT Cannon</li>
							<li>Moog</li>
						</ul>
					</div>
				</div>
			</div>
			<div id = "machines">
				<h2 id = "machines-tag"><i class="fa fa-cog" aria-hidden="true"></i><span class = "icon-text">Equipment</span></h2>
				<div class = "info machines">
					<h3>Milling</h3>
					<table>
						<tr>
							<td>Mori Seiki SH-400 Horizontal Machining Center</td>
							<td>400mm pallet with 8 station tombstones x 2</td>
							<td>40 tool capacity</td>
							<td>12,000 RPM</td>
						</tr>
						<tr>
							<td>Mori Seiki SV503B VMC with 4th axis machining</td>
							<td>50" x 21" travel</td>
							<td>18" z travel</td>
							<td>10,000 RPM</td>
						</tr>
						<tr>
							<td>Mori Seiki SV503B VMC with 4th axis machining</td>
							<td>50" x 21" travel</td>
							<td>18" z travel</td>
							<td>10,000 RPM</td>
						</tr>
						<tr>
							<td>Mori Seiki Frontier MIII 3-Axis VMC</td>
							<td>40" x 20" tabel</td>
							<td>32" x 18" x 18" travel</td>
							<td>8,000 RPM</td>
						</tr>
						<tr>
							<td>Haas Mini Mill with Integral 4th Axis</td>
							<td>36" x 12" table</td>
							<td>28" x 12" x 12" travel</td>
							<td>6,000 RPM</td>
						</tr>
						<tr>
							<td>Hitachi Seiki VM40 3-Axis VMC</td>
							<td>36" x 18" table</td>
							<td>28" x 18" x 18" travel</td>
							<td>6,000 RPM</td>
						</tr>
					</table>
					<h3>Turning</h3>
					<table>
						<tr>
							<td>Mori Seiki SL200SMC 2 Spindle lathe with live milling</td>
							<td>12" turning diameter</td>
							<td>20" length</td>
							<td>2.5" through bore</td>
						</tr>
						<tr>
							<td>Mori Seiki SL200 Very High Precision Lathe</td>
							<td>12" turning diameter</td>
							<td>20" length</td>
							<td>2.5" through bore</td>
						</tr>
						<tr>
							<td>Mori Seiki SL200 High Precision Lathe</td>
							<td>12" turning diameter</td>
							<td>20" length</td>
							<td>2.5" through bore</td>
						</tr>
						<tr>
							<td>Mori Seiki Frontier LII Turning Center</td>
							<td>14" turning diameter</td>
							<td>21" length</td>
							<td>2.625" through bore</td>
						</tr>
						<tr>
							<td>Hitachi Seiki HiTec Turn CNC Lathe</td>
							<td>8" Power chuck, colllet closer</td>
							<td>2" through bore</td>
							<td></td>
						</tr>
					</table>
				</div>
			</div>
			<!--<div id = "images">
				<h2 id = "images-tag">Our Capabilities</h2>
				<div class = "pictures">
					<h3>Part examples</h3>
					<div class = "thumb"><img src = "test-gallery-image.png" alt = "part"></div>
					<div class = "thumb"><img src = "test-gallery-image.png" alt = "part"></div>
					<div class = "thumb"><img src = "test-gallery-image.png" alt = "part"></div>
					<div class = "thumb"><img src = "test-gallery-image.png" alt = "part"></div>
				</div>
			</div>-->
			<div id = "contacts">
				<h2 id = "contacts-tag"><i class="fa fa-envelope" aria-hidden="true"></i><span class = "icon-text">Contact Us</span></h2>
				<div class = "info contacts">
					<div class = "split-div general">
						<div id = "c-list">
							<h3>Contacts</h3>
							<?php 
								$data = mysqli_query($link, "SELECT first_name, last_name, email, position FROM users WHERE display_info = '1'");
								while ($row = mysqli_fetch_array($data, MYSQL_NUM))
								{
									echo "<p>" . $row[3] . ": " . $row[0] . " " . $row[1] . " - " . $row[2] . "</p>";
								}
							?>
						</div>
						<h3>General Contact</h3>
						<p>SML Engineering</p>
						<p>1700 B Newport Circle Santa Ana, CA 92705</p>
						<p>(714) 549-2744</p>
						<p>fax: (714) 549-8731</p>
					</div>
					<div class = "split-div quote">
						<h3 id = "quote-tab">Request A Quote</h3>
						<form action="" method="post">
							<label for = "fname">Name:</label><br>
							<input type = "text" name = "fname" placeholder = "Jonathan Livingston Seagull"><br>
							<label for = "lname">Company:</label><br>
							<input type = "text" name = "lname" placeholder = "Flight Inc."><br>
							<label for = "email">E-mail:</label><br>
							<input type="email" name="mail" placeholder = "jseagull@flight.com"><br>
							<label for = "attachedfile">Attach a Drawing:</label><br>
							<input type = "file" name = "attachedfile" allow = "text/*" maxlength = "50"><br>
							<label for = "comment">Comments:</label><br>
							<textarea rows "4" cols = "50" name="comment" placeholder = "your message"></textarea><br><br>
							<div class = "end-buttons">
								<button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</input>
								<button type="reset">Reset</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<footer>
				<h3>SML Engineering</h3>
			</footer>
		</div>
	</div>
	<script>
		var app = angular.module("webApp", []);
	</script>
</body>
</html>