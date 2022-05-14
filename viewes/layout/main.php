<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://localhost/php-mvc/public/assets/css/style.css">
    <link rel="stylesheet" href="http://localhost/php-mvc/public/assets/css/icons.css">
</head>
<body class="rtl-grid">
<header id="header">
    <div class="container mx-auto w-full ">
        <nav class="w-full  top-0 py-2">
            <ul class="flex align-middle ">
                <li><a class="p-4 text-white text-lg text-gray-700 hover:text-gray-900" href="/php-mvc/">خانه</a>
                </li>
                <li><a class="p-4 text-white text-lg text-gray-700 hover:text-gray-900"
                       href="">محصولات</a></li>
                <li><a class="p-4 text-white text-lg text-gray-700 hover:text-gray-900"
                       href="/php-mvc/login/">ورود</a></li>
                <li><a class="p-4 text-white text-lg text-gray-700 hover:text-gray-900"
                       href="/php-mvc/register/">ثبت نام</a></li>
                <?php use app\core\Application;

                if (Application::$app->isGuest() == false): ?>
                    <li><a class="p-4 text-white font-mono text-lg"
                           href="/php-mvc/profile/">پروفایل</a>
                    </li>
                    <li><a class="p-4 text-white font-mono text-lg"
                           href="/php-mvc/logout/"><?php echo Application::$app->user->displayName() ?>
                            <small>(خروج)</small></a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php
        if (Application::$app->session->getFlashSession('success')):?>
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                 role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-4 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Success</p>
                        <p class="text-sm"> <?php echo Application::$app->session->getFlashSession('success') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>

{content}

<footer id="footer">
    <div class="container w-full mx-auto sticky bottom-0 right-0 left-0 right-0 text-center bg-slate-800 text-white py-1">
        <div class="my-8 flex justify-center text-myGray">
            <a href="" target="_blank" class="flex items-center justify-center mx-1.5"><i
                        class="icon-linked_in_circle text-3xl text-myGray"></i><span
                        class="hidden md:inline-block">لینکدین</span></a>
            <a href="" target="_blank" class="flex items-center justify-center mx-1.5 "><i
                        class="icon-facebook_circle text-3xl text-myGray"></i><span class="hidden md:inline-block">فیسبوک</span></a>
            <a href="" target="_blank" class="flex items-center justify-center mx-1.5 "><i
                        class="icon-instagram_circle text-3xl text-myGray"></i><span
                        class="hidden md:inline-block">اینستاگرام</span></a>
            <a href="" target="_blank" class="flex items-center justify-center mx-1.5"><i
                        class="icon-twitter_circle text-3xl text-myGray"></i><span
                        class="hidden md:inline-block">توییتر</span></a>
        </div>
        <div class="md:grid md:grid-cols-3 gap-4 mt-10">
            <div>
                <h3 class="text-xl mb-4">آدرس شرکت</h3>
                <p class="text-sm">
                    ایران - تهران <br>
                    خیابان شریعتی کوچه موسوی <br>
                    پلاک 7 واحد 11
                </p>
            </div>
            <div>
                <h3 class="text-xl mb-4">ایمیل</h3>
                <p class="text-sm">
                    contact@sample.com <br>
                    office@sample.com
                </p>
            </div>
            <div>
                <h3 class="text-xl mb-4">شماره تماس</h3>
                <p class="text-sm">
                    008 4585 500 50 <br>
                    008 4585 500 50 <br>
                    008 4585 500 50
                </p>
            </div>
        </div>
        <br>
    </div>
</footer>
</body>
</html>