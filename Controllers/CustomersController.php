<?php

namespace App\Http\Controllers\Api;

use App\Forms\Admin\Customers\ContactUsForm;
use App\Forms\Admin\Customers\CustomerDeleteForm;
use App\Forms\Admin\Customers\CustomerEditForm;
use App\Forms\Admin\Customers\CustomerGetForm;
use App\Handlers\Services\Classes\Datatable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Users\UsersRepository;
use App\Requests\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CustomersController extends Controller
{
    /**
     * Service Model
     *
     * @var UsersRepository
     */
    public UsersRepository $model;

    /**
     * Initialize Attributes
     *
     * @param UsersRepository $model
     */
    public function __construct(UsersRepository $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = (new Datatable($this->model, $request))->run();

            return new JsonResponse($result, Response::HTTP_OK);
        } catch (\Exception $e) {

            return new JsonResponse([
                'error' => 'Something went wrong.',
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function get($id): JsonResponse
    {
        try {
            $result = app(CustomerGetForm::class)
                ->setId($id)
                ->run();

            return new JsonResponse($result->data, $result->code);
        } catch (\Exception $e) {

            return new JsonResponse([
                'error' => 'Something went wrong.',
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function update($id): JsonResponse
    {
        try {
            $result = app(CustomerEditForm::class)
                ->setId($id)
                ->run();

            return new JsonResponse($result->data, $result->code);
        } catch (\Exception $e) {

            return new JsonResponse([
                'error' => 'Something went wrong.',
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $result = app(CustomerDeleteForm::class)
                ->setModel(new User)
                ->setId($id)
                ->run();

            return new JsonResponse($result->data, $result->code);
        } catch (\Exception $e) {

            return new JsonResponse([
                'error' => 'Something went wrong.',
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
