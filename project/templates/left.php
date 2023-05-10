<div class="left-wrapper">
    <div class="menu-btn block-centered">
        <img src="\project\webroot\images\menu-round.svg" alt="Меню" class="btn-menu s-40">
    </div>
    <div class="left">
        <menu>
            <a href="/news" class="menu_item">
                <div class="menu_icon">
                    <img src="\project\webroot\images\menu\newspaper.svg" class="menu_img">
                </div>
                <span>Новости</span>
            </a>
            <a href="/schedule" class="menu_item">
                <div class="menu_icon">
                    <img src="\project\webroot\images\menu\calendar3.svg" class="menu_img">
                </div>
                <span>Расписание</span>
            </a>
            <?php if ($user->role === 'Заказчик' || $user->role === 'Менеджер') { ?>
                <a href="/chats" class="menu_item">
                    <div class="menu_icon">
                        <img src="\project\webroot\images\menu\chat-left-text.svg" class="menu_img">
                    </div>
                    <span>Чаты</span>
                </a>
            <?php } ?>
            <?php if ($user->role === 'Заказчик') { ?>
                <a href="/payment" class="menu_item">
                    <div class="menu_icon">
                        <img src="\project\webroot\images\menu\wallet2.svg" class="menu_img">
                    </div>
                    <span>График оплат</span>
                </a>
            <?php } ?>
            <?php if ($user->role === 'Обучающийся') { ?>
                <a href="/cloud" class="menu_item">
                    <div class="menu_icon">
                        <img src="\project\webroot\images\menu\cloud.svg" class="menu_img">
                    </div>
                    <span>Облако</span>
                </a>
            <?php } ?>
            <?php if ($user->role === 'Менеджер') { ?>
                <a href="/admin" class="menu_item">
                    <div class="menu_icon">
                        <img src="\project\webroot\images\menu\tools.svg" class="menu_img">
                    </div>
                    <span>Администрирование</span>
                </a>
            <?php } ?>
        </menu>
        <div class="left_user">
            <a href="/profile" class="menu_item">
                <div class="menu_icon">
                    <img src="<?= $user->avatar ?>" class="avatar">
                </div>
                <div class="nick">
                    <?= $user->nick ?>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .menu-btn {
        display: none;
    }

    @media (max-width: 767px) {
        .container {
            /* display: block; */
            flex-direction: column;
            margin: 0;
        }

        .left-wrapper {
            position: sticky;
            top: 70px;
            z-index: 1;
        }

        .left {
            height: unset;
            background-color: #F8F9FA;
            position: absolute;
            top: -400px;
            width: 100%;
            transition: top 0.5s ease-in-out;
            border-bottom: 2px solid lightgray;
            border-radius: 0 0 40px 40px;
        }

        .left_user>a {
            justify-content: center;
        }

        .menu-btn {
            background-color: lightgrey;
            position: relative;
            z-index: 2;
        }

        .left.active {
            top: 40px;
        }

        .menu-btn {
            cursor: pointer;
            display: flex;
        }

        .content {
            padding-top: 10px;
        }

        .btn-menu {
            transition: 1s;
        }

        .btn-menu.active {
            transform: rotate(180deg);
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var menuBtn = document.querySelector(".menu-btn");
        var left = document.querySelector(".left");
        var btn_menu = document.querySelector(".btn-menu");
        menuBtn.addEventListener("click", function () {
            left.classList.toggle("active");
            btn_menu.classList.toggle("active");
        });
    });

</script>