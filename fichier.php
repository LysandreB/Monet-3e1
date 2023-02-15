<?php
$dbrequest = new PDO('mysql:host=localhost;dbname=polaroid','root','root');
if(isset($_POST['addimage'])) {
	$dataImage = [
	'img_link' => 'images/' . $_FILES['image']['name'],
	'img_file' => $_FILES['image']['tmp_name']
	];
	$data = [
	'title' => htmlspecialchars($_POST['title']),
	'img_link' => $dataImage['img_link']
	];
	move_uploaded_file($dataImage['img_file'], $dataImage['img_link']);
	$addImage = $dbrequest->prepare("INSERT INTO images(title, link) VALUES(:title, :img_link)");
	$addImage->execute($data);
}

$getDataImages = $dbrequest->prepare("SELECT*FROM images");
$getDataImages -> execute();
$images = $getDataImages->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport"
			content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Les réponses de 3è1</title>
		<link rel="stylesheet" href="style2.css">
	</head>
	<body>
	<div class="container">
		<div class="addimages">
			<h1>Ajoutez une image</h1>
			<div class="addimages_form">
				<form action="" method="post" enctype="multipart/form-data">
					<div>
						<label for="title">Nom de la photo:</label>
						<input type="text" name="title" id="title">
					</div>
					<div>
						<label for="photo">Choisir une photo:</label>
						<input type="file" accept="image/png, image/jpeg" name="image">
					</div>
					<button type="submit" name="addimage">Envoyer la photo</button>
				</form>
			</div>
		</div>
		<div class="showimages"> 
		<?php foreach($images as $image){ ?>
		<div class="polaroid">
		<div class="polaroid_image">
		<img src="<?php echo $image['link']; ?>" alt="<?php echo $image['titre']; ?>">
		</div>
		</div>
		<?php } ?>
		</div>
	</div>
	</body>
</html>