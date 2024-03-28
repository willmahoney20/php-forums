<?php include('views/partials/navbar.php'); ?>

<div class="container mx-auto flex flex-col justify-center items-center p-4 pb-12" style="min-height: calc(100vh - 104px);">
    <div class="w-80 mb-4">
        <h1 class="text-3xl text-white font-bold">Login</h1>
    </div>
    <form class="flex flex-col w-80" method="POST">
        <div class="flex flex-col mb-4">
            <label for="username" class="text-white text-sm font-medium mb-1">Username or Email</label>
            <input type="text" name="username" value="<?php echo $_POST['username']; ?>" class="bg-transparent border rounded border-white text-white text-sm h-8 w-full px-2" placeholder="Enter your username or email..." required>
        </div>
        <div class="flex flex-col mb-4">
            <label for="password" class="text-white text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" value="<?php echo $_POST['password']; ?>" class="bg-transparent border rounded border-white text-white text-sm h-8 w-full px-2" placeholder="Enter your password..." required autocomplete="off">
        </div>
        <div class="flex flex-col mb-2">
            <p class="text-white text-sm font-normal">Don't have an account? Join <a href="/signup" class="text-green-500">here.</a></p>
        </div>

        <?php if($_SESSION['notifications']['login-error']){ ?>
            <div class="flex flex-col mb-2">
                <p class="text-red-500 text-sm font-normal">
                    <?= $_SESSION['notifications']['login-error'][0]; ?>
                </p>
            </div>
            <?php unset($_SESSION['notifications']); ?>
        <?php } elseif($_SESSION['notifications']['signup-success']){ ?>
            <div class="flex flex-col mb-2">
                <p class="text-green-500 text-sm font-normal">
                    <?= $_SESSION['notifications']['signup-success'][0]; ?>
                </p>
            </div>
            <?php unset($_SESSION['notifications']); ?>
        <?php } ?>

        <input type="submit" name="submit" value="Login" class="bg-transparent font-medium text-sm text-white border-2 border-white rounded-lg w-24 h-8 mt-3 cursor-pointer">
    </form>
</div>

<?php include('views/partials/footer.php'); ?>