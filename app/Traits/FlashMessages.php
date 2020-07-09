<?php

namespace App\Traits;

trait FlashMessages {
    /**
     * @var array
     */
    protected $errorMessages = [];

    /**
     * @var array
     */
    protected $infoMessages = [];

    /**
     * @var array
     */
    protected $successMessages = [];

    /**
     * @var array
     */
    protected $warningMessages = [];


    /**
     * @var $message
     * @var $type
     */
    protected function setFlashMessage($message, $type)
    {
        $model = 'infoMessages';

        switch($type){
            case 'info' : {
                $model = 'infoMessages';
            }
                break;
            case 'error': {
                $model = 'errorMessages';
                }
                break;
            case 'success': {
                $model = 'successMessages';
                }
                break;
            case 'warning': {
                $model = 'warningMessages';
                }
                break;
        }

        if (is_array($message)) {
            foreach ($message as $key => $value)
            {
                array_push($this->$model, $value);
            }
        } else {
            array_push($this->$model, $message);
        }
    }

    /**
     * @return array
     */
    protected function getFlashMessage()
    {
        return [
            'error'   => $this->errorMessages,
            'info'    => $this->infoMessages,
            'success' => $this->successMessages,
            'warning' =>$this->warningMessages,
        ];
    }

    /**
     * Flushing flash messages to Laravel's session
     */
    protected function showFlashMessages()
    {
        session()->flash('error', $this->errorMessages);
        session()->flash('info', $this->infoMessages);
        session()->flash('success', $this->successMessages);
        session()->flash('warning', $this->warningMessages);
    }

     /**
     * @param $route
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function responseRedirect($route, $message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        if ($error && $withOldInputWhenError) {
            return redirect()->back()->withInput();
        }

        return redirect()->route($route);
    }

    /**
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function responseRedirectBack($message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        return redirect()->back();
    }
}
