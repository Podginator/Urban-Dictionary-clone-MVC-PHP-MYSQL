<div class="container">
    <div class = "box">
        <div class="boxcontainer">
            <h2> Admin Page: </h2>
        </div>
    </div>

    <div class = "form box">
        <div class="formdiv">
            <h2>Add Category.</h2>
            <form action="<?php echo URL; ?>Admin/AddCategory" method="post">
                <br/>
                <label>Category:</label>
                <input type="text" name="category" placeholder="Category">
                <input type="submit" value="Submit"/>
            </form>
        </div>
    </div>

    <div class = "form box">
        <div class="formdiv">
            <h2>Make user Admin.</h2>
            <form action="<?php echo URL; ?>Admin/MakeAdmin" method="post">
                <br/>
                <label>User:</label>
                <input type="text" name="user" placeholder="username">
                <input type="submit" value="Submit"/>
            </form>
        </div>
    </div>


</div>
