<?php
    class Install {
        public function genUniqueHash($blogname){
            // Generate unique safety hash to security MyBlog users
            $size = (int) 26;
            $random = random_bytes($size);
            $random = "myb-unique-hash-$random-hash-" . $blogname;
            return (sha1(bin2hex($random)) . time() . min($size,40));
        }
    }

    $ins = new Install();
    $ins->genUniqueHash();
?>