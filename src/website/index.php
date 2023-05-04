<!DOCTYPE html>
<html>
<head>
	<title>Scoreboard</title>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		th {
			background-color: #4CAF50;
			color: white;
		}
	</style>
</head>
<body>
	<h1>Scoreboard</h1>
	<table>
		<tr>
			<th>Rank</th>
			<th>User</th>
			<th>All Time</th>
			<th>Score</th>
			<th>Codeforces Ranking</th>
		</tr>
		<?php include "scoreboard.php"; ?>
	</table>
</body>
	<script>
	setInterval(function() {
  		location.reload();
	}, 30000);
	</script>
</html>
