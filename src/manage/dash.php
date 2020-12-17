<?php
    use MyB\User as User;
    use MyB\Sql as DB;
    require_once(dirname(__FILE__) . '/../../libs/class/user.class.php');
    require_once(dirname(__FILE__) . '/../../libs/sql/pdo.class.php');

    function getdba(){
        $db = new DB();
        $vals = array(
            'user' => 'Admin',
            'email' => 'admin@myblog.dot'
        );
        $row = $db->sup_select('users',$vals);
        return $row;
    }


    $user = new User();
    if($user->session()):
?>
<header>

</header>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<h1>Dashboard</h1>
<style>
*{
    margin:0;
    padding:0;
}
body {
    background: #e2e1e0;
    width:100%;
    height: 100%;
    display:flex;
    flex-direction:row;
}
header {
    position: relative;
    width:100%;
    height:50px;
    background:blue;
}


main {
    position:relative;
    float:right;
}
section > article {
    display: inline-block;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    border-radius: 5px;
    padding:10px;
    margin: 10px;
    width: 300px !important;
    height: 400px;
}

</style>

<main>
    <section>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
        <article>
            <h2>Post Boxes</h2>
            <p>Post Contents</p>
        </article>
    </section>
</main>
<?php
    else:
        header("Location: $URL/login?go=/dash");
    endif;
?>