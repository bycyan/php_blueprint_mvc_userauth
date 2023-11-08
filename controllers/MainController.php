<?php
require_once "models/UserModel.php";
require_once "controllers/UserController.php";

class MainController
{
    protected $db;
    protected $response;
    protected $request;
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
        $this->request = $this->getRequest();
        $this->response = $this->validateRequest($this->request);
        $this->showResponse();
    }

    private function getRequest(): array
    {
        $requestMethod = ($_SERVER['REQUEST_METHOD'] === 'POST');
        $page = $this->getRequestVar('page', $requestMethod, 'home');

        return [
            'post' => $requestMethod,
            'page' => $page,
        ];
    }

    private function validateRequest(array $request): array
    {
        $result = $request;
        if ($request['post']) {
            $this->handlePostRequest($result);
        } else {
            $this->handleGetRequest($result);
        }
        return $result;
    }

    private function showResponse()
    {
        $response = $this->response;
        $this->handlePageViews($response);
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

    private function handlePostRequest($request)
    {
        $name = $this->getRequestVar('name', true, '');
        $email = $this->getRequestVar('email', true, '');
        $password = $this->getRequestVar('password', true, '');

        switch ($request['page']) {
            case 'login':
                $this->userController->loginUser($email);
                break;
            case 'register':
                $this->userController->registerUser($name, $email, $password);
                break;
        }
    }

    private function handleGetRequest($request)
    {
        switch ($request['page']) {
            case 'logout':
                $this->response = $this->userController->unsetUser();
                break;
        }
    }

    private function handlePageViews($response)
    {
        $page = 'home';
        switch ($response['page']) {
            default:
                require_once "views/HomeView.php";
                $page = new HomeView($response);
                break;
            case 'login':
                require_once "views/LoginView.php";
                $page = new LoginView($response);
                break;
            case 'register':
                require_once "views/RegisterView.php";
                $page = new RegisterView($response);
                break;
        }

        if ($page) {
            $page->renderHTML();
        } else {
            echo 'Page not found';
        }
    }
}
