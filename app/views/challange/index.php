
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin Board Level 1</title>
    <link rel="stylesheet" href="<?= BASEURL;?>/css/challange1.css">
</head>
<body>
 

          
    <div class="container">
        <h1>Bulletin board Level 1</h1>
        <div class="board">
                <?php Flasher::flash()?>
            <form method="post" id="messageForm" action="<?= BASEURL?>/bulletin/store">
                <textarea name="text" id="messageInput" placeholder="Must be filled in"></textarea>
                <button type="submit">Submit</button>
            </form>
            <div class="messages">
                <?php foreach($data['bulletin'] as $row): ?>
                <div class="message">
                    <p><?= $row['text']?></p>
                    <span class="timestamp"><?= $row['timestamp']?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
