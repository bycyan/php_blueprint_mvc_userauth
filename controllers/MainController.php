<?php
require_once "models/UserModel.php";
require_once "controllers/UserController.php";
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

    private function handlePostRequest()
    {
        $name = $this->getRequestVar('name', true, '');
        $email = $this->getRequestVar('email', true, '');
        $password = $this->getRequestVar('password', true, '');
        $errorMessages = [];

        switch ($this->response['page']) {
            case 'login':
                $this->userController->loginUser($email, $password);
                $this->response['page'] = 'home';
                break;
            case 'register':
                try {
                    $registrationResult = $this->userController->register($name, $email, $password);
                    if ($registrationResult === true) {
                        $this->response['page'] = 'login';
                        $this->userController->loginUser($email, $password);
                    }
                } catch (Exception $e) {
                    $errorMessages[] = $e->getMessage();
                }
                $this->response['errorMessages'] = $errorMessages;
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
        if (isset($this->response['errorMessages'])) {
            foreach ($this->response['errorMessages'] as $errorMessage) {
                error_log("Error: " . $errorMessage);
                echo "<p>Error: $errorMessage</p>";
            }
        }
        switch ($this->response['page']) {
            default:
                require_once "views/HomeView.php";
                $page = new HomeView($this->response);

                break;
            case 'login':
                require_once "views/LoginView.php";
                $page = new LoginView($this->response);
                break;
            case 'register':
                require_once "views/RegisterView.php";
                $page = new RegisterView($this->response);
                break;
        }

        if ($page) {
            if (isset($this->response['errorMessages'])) {
                foreach ($this->response['errorMessages'] as $errorMessage) {
                }
            }
            $page->renderHTML();
        } else {
            echo 'Page not found';
        }
    }
}
