<?php 
require_once("includes/config.php");

if(!empty($_POST["bookid"])) {
    $bookid = trim($_POST["bookid"]);

    // Prepare the query to get book info
    $sql = "SELECT 
                b.id as bookid,
                b.BookName,
                b.ISBNNumber,
                b.bookImage,
                b.bookQty,
                b.BookPrice,
                a.AuthorName,
                c.CategoryName,
                COUNT(ibd.id) AS issuedBooks,
                SUM(CASE WHEN ibd.RetrunStatus='1' THEN 1 ELSE 0 END) AS returnedBooks
            FROM tblbooks b
            LEFT JOIN tblauthors a ON a.id = b.AuthorId
            LEFT JOIN tblcategory c ON c.id = b.CatId
            LEFT JOIN tblissuedbookdetails ibd ON ibd.BookId = b.id
            WHERE b.ISBNNumber = :bookid OR b.BookName LIKE :bookname
            GROUP BY b.id";

    $query = $dbh->prepare($sql);
    $likeBookName = "%$bookid%";
    $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
    $query->bindParam(':bookname', $likeBookName, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0){
        echo '<table border="0" width="100%"><tr>';
        foreach ($results as $result) {
            $aqty = $result->bookQty - ($result->issuedBooks - $result->returnedBooks);
            ?>
            <th style="padding:10px; text-align:center;">
                <img src="bookimg/<?php echo htmlentities($result->bookImage); ?>" width="120"><br />
                <b><?php echo htmlentities($result->BookName); ?></b><br />
                <?php echo htmlentities($result->AuthorName); ?><br />
                Category: <?php echo htmlentities($result->CategoryName); ?><br />
                Book Quantity: <?php echo htmlentities($result->bookQty); ?><br />
                Available: <?php echo htmlentities($aqty); ?><br />

                <?php if($aqty <= 0): ?>
                    <p style="color:red;">Book not available for issue.</p>
                <?php else: ?>
                    <input type="radio" name="bookid" value="<?php echo htmlentities($result->bookid); ?>" required>
                    <input type="hidden" name="aqty" value="<?php echo htmlentities($aqty); ?>" required>
                <?php endif; ?>
            </th>
            <?php
        }
        echo '</tr></table>';
        echo "<script>$('#submit').prop('disabled', false);</script>";
    } else {
        echo "<p>Record not found. Please try again.</p>";
        echo "<script>$('#submit').prop('disabled', true);</script>";
    }
}
?>
