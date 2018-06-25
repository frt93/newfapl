<?php namespace App\Http\Composers;

class infinitePaginationComposer {

    public function compose($view)
    {
        $view->with([
            'loadBtnValue' => 'Загрузить еще',
            'loadingText' => 'Загружаем предыдущие статьи',
            'fetchErrMsg' => 'Не удается обработать запрос. Подождите...'
        ]);
    }
}