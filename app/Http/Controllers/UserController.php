<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests;
use App\Http\Requests\UserRequest as CreateUserRequest;
use App\Http\Requests\UserRequest as UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepositorysitory;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create', [
            'validator'=> JsValidator::formRequest(CreateUserRequest::class, '#crud-form'),
        ]);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);

        Flash::success(trans('messages.saved', ['model' => trans('models/users.singular')]));

        return redirect()->route('users.index');
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error(trans('messages.not_found', ['model' => trans('models/users.singular')]));

            return redirect()->route('users.index');
        }

        return view('users.show', [
            'user'=> $user,
        ]);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error(trans('messages.not_found', ['model' => trans('models/users.singular')]));

            return redirect()->route('users.index');
        }

        return view('users.edit', [
            'validator'=> JsValidator::formRequest(CreateUserRequest::class, '#crud-form'),
            'user'=> $user,
        ]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error(trans('messages.not_found', ['model' => trans('models/users.singular')]));

            return redirect()->route('users.index');
        }

        $user = $this->userRepository->update($request->all(), $id);

        Flash::success(trans('messages.updated', ['model' => trans('models/users.singular')]));

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error(trans('messages.not_found', ['model' => trans('models/users.singular')]));

            return redirect()->route('users.index');
        }

        $this->userRepository->delete($id);

        Flash::success(trans('messages.deleted', ['model' => trans('models/users.singular')]));

        return redirect()->route('users.index');
    }
}
