<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\App\Http\Controllers;

use App\Http\Resources\V1\JsonResourceCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;

abstract class Controller extends \Illuminate\Routing\Controller
{
    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int, TModelClass>| TModelClass|array< TModelClass>| JsonResource| JsonResourceCollection  $data
     */
    public function ok(array|Model|Collection|JsonResource|JsonResourceCollection $data = [], string $message = ''): JsonResponse
    {
        return $this->response(data: $data, message: $message, success: true);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int,TModelClass>|TModelClass|array<TModelClass>| JsonResource| JsonResourceCollection  $data
     */
    public function created(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = ''): JsonResponse
    {
        return $this->response(data: $data, message: $message, success: true, statusCode: Response::HTTP_CREATED);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int,TModelClass>|TModelClass|array<TModelClass>| JsonResource| JsonResourceCollection  $data
     */
    public function noContent(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = ''): JsonResponse
    {
        return $this->response(data: $data, message: $message, success: true, statusCode: Response::HTTP_NO_CONTENT);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int,TModelClass>|TModelClass|array<TModelClass>| JsonResource| JsonResourceCollection  $data
     * @param  array<MessageBag>  $errors
     */
    public function badRequest(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = '', array $errors = []): JsonResponse
    {
        return $this->response($data, $message, success: false, statusCode: Response::HTTP_BAD_REQUEST, errors: $errors);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int,TModelClass>|TModelClass|array<TModelClass> | JsonResource| JsonResourceCollection  $data
     * @param  array<MessageBag>  $errors
     */
    public function unauthorized(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = '', array $errors = []): JsonResponse
    {
        return $this->response($data, $message, success: false, statusCode: Response::HTTP_UNAUTHORIZED, errors: $errors);

    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int,TModelClass>|TModelClass|array<TModelClass> | JsonResource| JsonResourceCollection  $data
     * @param  array<MessageBag>  $errors
     */
    public function forbidden(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = '', array $errors = []): JsonResponse
    {
        return $this->response($data, $message, success: false, statusCode: Response::HTTP_FORBIDDEN, errors: $errors);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int,TModelClass>|TModelClass|array<TModelClass>| JsonResource| JsonResourceCollection  $data
     * @param  array<MessageBag>  $errors
     */
    public function notFound(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = '', array $errors = []): JsonResponse
    {
        return $this->response($data, $message, success: false, statusCode: Response::HTTP_NOT_FOUND, errors: $errors);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int,TModelClass>|TModelClass|array<TModelClass>| JsonResource| JsonResourceCollection  $data
     * @param  array<MessageBag>  $errors
     */
    public function methodNotAllowed(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = '', array $errors = []): JsonResponse
    {
        return $this->response($data, $message, success: false, statusCode: Response::HTTP_METHOD_NOT_ALLOWED, errors: $errors);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int,TModelClass>|TModelClass|array<TModelClass>| JsonResource| JsonResourceCollection  $data
     * @param  array<MessageBag>  $errors
     */
    public function internalServerError(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = '', array $errors = []): JsonResponse
    {
        return $this->response($data, $message, success: false, statusCode: Response::HTTP_INTERNAL_SERVER_ERROR, errors: $errors);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int,TModelClass>|TModelClass|array<TModelClass>| JsonResource| JsonResourceCollection  $data
     * @param  array<MessageBag>  $errors
     */
    public function NotImplemented(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = '', array $errors = []): JsonResponse
    {
        return $this->response($data, $message, success: false, statusCode: Response::HTTP_NOT_IMPLEMENTED, errors: $errors);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int, TModelClass>| Model|array<Model>| JsonResource| JsonResourceCollection  $data
     * @param  array<MessageBag>  $errors
     */
    public function response(Model|Collection|array|JsonResource|JsonResourceCollection $data = [], string $message = '', bool $success = false, int $statusCode = Response::HTTP_OK, array $errors = []): JsonResponse
    {
        $response = [
            'success' => $success,
            'status_code' => $statusCode,
            'message' => $message,
        ];
        if (count($errors) != 0) {
            $response['errors'] = $errors;
        }

        $response = $this->formatCollectionResource($data, $response);

        return response()->json($response, $statusCode);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int, TModelClass>| Model|array<Model>| JsonResource| JsonResourceCollection  $data
     */
    private function isCollectionResource(Model|Collection|array|JsonResource|JsonResourceCollection $data): bool
    {

        return $data instanceof JsonResource && isset($data->resolve()['links']);
    }

    /**
     * @template TModelClass of Model
     *
     * @param  Collection<int, TModelClass>| Model|array<Model>| JsonResource  $data
     * @param  array<string,mixed>  $response
     * @return array<string,mixed>
     */
    private function formatCollectionResource(Model|Collection|array|JsonResource|JsonResourceCollection $data, array $response): array
    {
        if ($this->isCollectionResource($data)) {
            /**
             * @var JsonResource $data
             */
            return array_merge($response, $data->resolve());
        }
        $responseArray = $response;
        $responseArray['data'] = $data;

        return $responseArray;
    }
}
