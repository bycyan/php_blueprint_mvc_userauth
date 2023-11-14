<?php
require_once "models/UserModel.php";
require_once "controllers/UserController.php";
require_once "helpers/FormHandler.php";
class MainController
{
    protected $db;
    protected $response;
    protected $request;

    //waarom hier userModel aanroepen? kan dat niet simpeler?
    public $userModel;
    public $userController;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->userModel = new UserModel($db);
        $this->userController = new UserController($this->userModel);
    }

    //////////////////////////////////////////////////////////
    //MAIN FLOW
    //////////////////////////////////////////////////////////

    public function handleMainFlow()
    {
        $this->getRequest();
        $this->validateRequest();
        $this->showResponse();
    }

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

    public function getRequestVar(string $key, bool $frompost, $default = "", bool $asnumber = FALSE)
    {
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_SANITIZE_FULL_SPECIAL_CHARS;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET), $key, $filter);
        return ($result === FALSE) ? $default : $result;
    }

    //////////////////////////////////////////////////////////
    //HANDLERS
    //////////////////////////////////////////////////////////
    public $errorMessage = "";

    private function handlePostRequest()
    {
        $name = $this->getRequestVar('name', true, '');
        $email = $this->getRequestVar('email', true, '');
        $password = $this->getRequestVar('password', true, '');

        switch ($this->response['page']) {
            case 'login':
                try {
                    //todo: if login succes > $this->response['page'] = 'home';
                    $this->userController->loginUser($email, $password);
                } catch (Exception $errors) {
                    $this->errorMessage = $errors->getMessage();
                }


                break;

            case 'register':
                try {
                    $registrationResult = $this->userController->registerUser($name, $email, $password);
                    if ($registrationResult === true) {
                        $this->response['page'] = 'login';
                        $loginResult = $this->userController->loginUser($email, $password);
                        if ($loginResult === true) {
                            $this->response['page'] = 'home';
                        } else {
                            $errorMessages[] = "Login failed after registration. Please try logging in manually.";
                            $this->response['errorMessages'] = $errorMessages;
                        }
                    }
                } catch (Exception $errors) {
                    $this->errorMessage = $errors->getMessage();
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
        $page = 'home';
        switch ($this->response['page']) {
            default:
                require_once "views/HomeView.php";
                $page = new HomeView($this->response);
                break;
            case 'register':
                $page = $this->handleFormViewInst($this->response['page']);
                echo $this->errorMessage;
                break;
            case 'contact':
                $page = $this->handleFormViewInst($this->response['page']);
                break;
            case 'login':
                $page = $this->handleFormViewInst($this->response['page']);
                echo $this->errorMessage;
                break;
        }
        if ($page) {
            $page->renderHTML();
        } else {
            echo 'Page not found';
        }
    }

    private function handleFormViewInst($page)
    {
        require_once "views/FormView.php";
        return new FormView($page);
    }
}
