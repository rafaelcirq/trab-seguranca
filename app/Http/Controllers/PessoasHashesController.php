<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Entities\PessoasHash;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PessoasHashCreateRequest;
use App\Http\Requests\PessoasHashUpdateRequest;
use App\Repositories\PessoasHashRepository;
use App\Validators\PessoasHashValidator;

/**
 * Class PessoasHashesController.
 *
 * @package namespace App\Http\Controllers;
 */
class PessoasHashesController extends Controller
{
    /**
     * @var PessoasHashRepository
     */
    protected $repository;

    /**
     * @var PessoasHashValidator
     */
    protected $validator;

    /**
     * PessoasHashesController constructor.
     *
     * @param PessoasHashRepository $repository
     * @param PessoasHashValidator $validator
     */
    public function __construct(PessoasHashRepository $repository, PessoasHashValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $pessoasHashes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $pessoasHashes,
            ]);
        }

        return view('pessoasHashes.index', compact('pessoasHashes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PessoasHashCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store($pessoa)
    {
        try {

            $pessoa = $this->repository->create($pessoa);
            dd($pessoa);
            $response = [
                'success' => true,
                'message' => 'Dados salvos.',
                'data'    => $pessoa->toArray(),
            ];

            session()->flash('response', $response);

            return redirect()->back();
        } catch (\Exception $e) {
            // If errors...
            switch (get_class($e)) {

                case ValidatorException::class:
                    $message = $e->getMessageBag();
                    break;
                default:
                    $message = $e->getMessage();
                    break;
            }

            $response = [
                'success' => false,
                'message' => $message,
            ];

            return redirect()->back()->withErrors($response['message'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pessoasHash = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $pessoasHash,
            ]);
        }

        return view('pessoasHashes.show', compact('pessoasHash'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pessoasHash = $this->repository->find($id);

        return view('pessoasHashes.edit', compact('pessoasHash'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PessoasHashUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PessoasHashUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $pessoasHash = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PessoasHash updated.',
                'data'    => $pessoasHash->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'PessoasHash deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PessoasHash deleted.');
    }
}
