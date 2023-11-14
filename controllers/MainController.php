<?php
require_once "controllers/UserController.php";
class MainController
{
    protected $db;
    protected $response;
    protected $request;
    protected $userController;

    public function __construct(Database $db)
    {
        $this->userController = new UserController(new UserModel($db));
    }

    //////////////////////////////////////////////////////////
    //START MAIN FLOW
    //////////////////////////////////////////////////////////

    public function handleMainFlow()
    {
        $this->getRequest();
        $this->validateRequest();
        $this->showResponse();
    }

    //////////////////////////////////////////////////////////
    //GET, VALIDATE, SHOW
    //////////////////////////////////////////////////////////

    private function getRequest()
    {
        $requestMethod = ($_SERVER['REQUEST_METHOD'] === 'POST');
        $page = $this->getRequestVar('page', $requestMethod, 'home');

        $this->request =
            [
                'post' => $requestMethod,
                'page' => $page,
            ];
    }

    private function validateRequest()
    {
        $this->response = $this->request;
        if ($this->request['post']) {
            $this->handlePostRequest();
        } else {
            $this->handleGetRequest();
        }
    }

    private function showResponse()
    {
        $this->handlePageViews();
    }

    //////////////////////////////////////////////////////////
    //END MAIN FLOW
    //////////////////////////////////////////////////////////

    private function getRequestVar(string $key, bool $frompost, $default = "", bool $asnumber = FALSE)
    {
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_SANITIZE_FULL_SPECIAL_CHARS;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        return ($result === FALSE) ? $default : $result;
    }

    //////////////////////////////////////////////////////////
    //PAGE VIEW HANDLERS
    //////////////////////////////////////////////////////////

    private function handlePostRequest()
    {
        $name = $this->getRequestVar('name', true, '');
        $email = $this->getRequestVar('email', true, '');
        $password = $this->getRequestVar('password', true, '');

        switch ($this->response['page']) {
            case 'login':
                try {
                    $data = $this->userController->loginUser($email, $password);
                    if ($data === true) {
                        $this->response['page'] = 'home';
                    }
                } catch (Exception $errors) {
                    $this->response['errors'] = $this->userController->getFieldErrors();
                    $this->response['postResult'] = [
                        'email' => $email,
                        'password' => $password,
                    ];
                }
                break;

            case 'register':
                try {
                    $data = $this->userController->registerUser($name, $email, $password);
                    if ($data === true) {
                        $loginAfterRegister = $this->userController->loginUser($email, $password);
                        if ($loginAfterRegister === true) {
                            $this->response['page'] = 'home';
                        } else {
                            throw new Exception("Login failed after registration. Please try logging in manually.");
                        }
                    }
                } catch (Exception $errors) {
                    $this->response['errors'] = $errors->getMessage();
                }
                break;
        }
    }

    private function handleGetRequest()
    {
        switch ($this->response['page']) {
            case 'logout':
                $this->response = $this->userController->unsetUser();
                break;
        }
    }

    private function handlePageViews()
    {
        $errors = isset($this->response['errors']) ? $this->response['errors'] : [];

        $page = 'home';
        switch ($this->response['page']) {
            default:
                require_once "views/HomeView.php";
                $page = new HomeView($this->response);
                break;
            case 'login':
            case 'register':
            case 'contact':
                $page = $this->handleFormViewInst($this->response['page'], $errors);
                break;
        }
        if ($page) {
            $page->renderHTML();
        } else {
            echo 'Page not found';
        }
    }

    private function handleFormViewInst($page, $errors)
    {
        require_once "views/FormView.php";
        $errorsArray = is_array($errors) ? $errors : [$errors];
        return new FormView($page, $errorsArray);
    }
}
