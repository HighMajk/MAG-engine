<?php
class Gallery{
    public static function getGallery($conn){
        $query = mysqli_query($conn, "SELECT id, name, imageUrl FROM gallery ORDER BY id DESC");
        while($row = mysqli_fetch_array($query)) {
            ?>  
                <div class="col-lg-4 col-md-6 col-sm-12 p-2">
                    <div class="galleryItemBox">
                        <a href = "/?page=art&id=<?=$row['id']?>">
                            <img src="/storage/arts/<?=$row['imageUrl']?>" class="gallery-image">
                            <h5><?=$row['name']?></h5>
                        </a>
                    </div>
                </div>
            <?php
        }
    }
    public static function getArts($conn){
        $query = mysqli_query($conn, "SELECT id, name, imageUrl FROM gallery ORDER BY id DESC");
        $i = 0;
        $arts = [];
        while($row = mysqli_fetch_array($query)) {
           $name = $row['name'];
           $id = $row['id'];
           $imageUrl = $row['imageUrl'];
           $art = [$id, $name, $imageUrl];
           $arts[$i++] = $art;
        }
        
        return $arts;
    }

    public static function getArts2($conn, $quantity){
        $query = mysqli_query($conn, "SELECT id, name, imageUrl FROM gallery ORDER BY id DESC LIMIT $quantity");
        $i = 0;
        $arts = [];
        while($row = mysqli_fetch_array($query)) {
           $name = $row['name'];
           $id = $row['id'];
           $imageUrl = $row['imageUrl'];
           $art = [$id, $name, $imageUrl];
           $arts[$i++] = $art;
        }
        
        return $arts;
    }

    public static function addPicture($conn, $name, $description, $author, $catalogNumber, $status, $imgName, $price, $addedDate){
        if(Auth::isAdmin($conn) != true){
            return false;
        }

        $userID = Auth::getUserID($_SESSION['user'], $conn);

        mysqli_query($conn, "INSERT INTO gallery VALUES (NULL, '$name', '$description', '$author', '$price', '$status', '$userID','$addedDate', '$imgName', '$catalogNumber')");
        return true;
        
    }
    public static function getArtById($conn, $id){
        $query = mysqli_query($conn, "SELECT imageUrl, name, price, description, author, catalogNumber, status FROM gallery WHERE id=$id");
        while($row = mysqli_fetch_array($query)) {
            $imageUrl = $row['imageUrl'];
            $name = $row['name'];
            $price = $row['price'];
            $description = $row['description'];
            $author = $row['author'];
            $status = $row['status'];
            $catalogNumber = $row['catalogNumber'];
        }
        $art = [$name, $price, $imageUrl, $description, $author, $status, $catalogNumber];
        return $art;
    }
    public static function deleteArt($conn, $id){
        if(Auth::isAdmin($conn) != true){
            return false;
        }
        mysqli_query($conn, "DELETE FROM gallery WHERE id=$id");
        return true;
    }
    public static function editArt($conn, $name, $description, $author, $catalogNumber, $status, $price, $id){
        if(Auth::isAdmin($conn) != true){
            return false;
        }

        mysqli_query($conn, "UPDATE gallery SET name='$name', description='$description', author='$author', catalogNumber='$catalogNumber', status='$status', price='$price' WHERE id='$id'");
        return true;
    }
}