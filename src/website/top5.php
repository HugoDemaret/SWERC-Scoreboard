<!DOCTYPE html>
<html>
<head>
	<title>Scoreboard</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			text-align: center;
			margin: 0;
			padding: 0;
			background-color: #f2f2f2;
		}

		h1 {
			font-size: 48px;
			margin-top: 40px;
			margin-bottom: 20px;
		}

		h2 {
			font-size: 24px;
			margin-top: 20px;
			margin-bottom: 10px;
		}

		p {
			font-size: 18px;
			margin-top: 10px;
			margin-bottom: 10px;
			color: #666;
		}

		table {
			border-collapse: collapse;
			width: 80%;
			margin: auto;
			margin-top: 40px;
			margin-bottom: 40px;
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		th, td {
			text-align: left;
			padding: 16px;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		th {
			background-color: #4CAF50;
			color: white;
		}

		table td:first-child {
		font-size: 24px; /* Adjust the font size to your liking */
		}

		.message {
			background-color: #f9d6d6;
			color: #c0392b;
			font-size: 24px;
			padding: 20px;
			margin-top: 40px;
			margin-bottom: 40px;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		p.subtitle {
			font-size: 24px;
			margin-top: 0;
			margin-bottom: 40px;
		}

		p.important {
			font-size: 20px;
			font-weight: bold;
			color: #FF6F61;
			margin-bottom: 40px;
		}
	</style>
</head>
<body>
<div class="container">
		<table>
			<tr>
				<th>Rank</th>
				<th>User</th>
				<th>All Time</th>
				<th>Score</th>
				<th>Codeforces Ranking</th>
			</tr>
			<?php include "scoreboard_top5.php"; ?>
		</table>
	</div>
</body>
	<script>
	setInterval(function() {
  		location.reload();
	}, 30000);
	</script>
</html>
