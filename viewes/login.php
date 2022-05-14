<div class="flex items-center justify-center min-h-screen bg-gray-100 font-mono">
    <div class="px-8 py-6 mx-4 text-left bg-white shadow-lg md:w-1/3 lg:w-1/3 sm:w-1/3">
        <?php use app\core\Form\Form;
        $form = app\core\Form\Form::startForm('post')  ?>
        <?php /** @var \app\core\Model $model */
        echo $form->newField($model,'email') ?>
        <?php echo $form->newField($model,'password')->setTypePass() ?>
        <div class="mt-4">
            <div class="flex">
                <button type="submit" class="w-full px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">ورود</button>
            </div>
            <div class="mt-6 text-grey-dark">
                قبلا ثبت نام کرده اید؟
                <a class="text-blue-600 hover:underline" href="/php-mvc/register/">
                    ثبت نام
                </a>
            </div>
        </div>
        <?php echo Form::endForm() ?>
    </div>
</div>