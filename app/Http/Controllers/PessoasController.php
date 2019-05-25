<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PessoasCreateRequest;
use App\Http\Requests\PessoasUpdateRequest;
use App\Repositories\PessoasRepository;
use App\Repositories\PessoasHashRepository;
use App\Validators\PessoasValidator;
use App\Presenters\PessoasHashPresenter;
use Illuminate\Support\Facades\Hash;
use App\Entities\PessoasHash;
use Hamcrest\Util;

/**
 * Class PessoasController.
 *
 * @package namespace App\Http\Controllers;
 */
class PessoasController extends Controller
{
    /**
     * @var PessoasRepository
     */
    protected $repository;

    /**
     * @var PessoasValidator
     */
    protected $validator;

    /**
     * @var PessoasHashRepository
     */
    protected $hashRepository;

    /**
     * PessoasController constructor.
     *
     * @param PessoasRepository $repository
     * @param PessoasValidator $validator
     */
    public function __construct(PessoasRepository $repository, PessoasHashRepository $hashRepository, PessoasValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->hashRepository = $hashRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $pessoas = $this->repository->all();
        // $dadosConsistentes = true;

        foreach ($pessoas as $pessoa) {
            // dd($pessoa);
            // $this->hashRepository->setPresenter(PessoasHashPresenter::class);
            $hash = $this->hashRepository->find($pessoa->id);
            if (
                // is_null($hash) ||
                !Hash::check($pessoa->nome, $hash->nome) ||
                !Hash::check($pessoa->cidade, $hash->cidade)
            ) {
                return view('erro.inconsistencia');
            }
        }
        return view('pessoas.index', compact('pessoas'));

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $pessoas,
            ]);
        }
    }

    public function create()
    {
        return view('pessoas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PessoasCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PessoasCreateRequest $request)
    {
        try {
            $data =  $request->all();

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $pessoa = $this->repository->create($data);

            $pessoaHashData['nome'] = Hash::make($pessoa['nome']);
            $pessoaHashData['cidade'] = Hash::make($pessoa['cidade']);

            $respostaHash = $this->hashRepository->create($pessoaHashData);

            $response = [
                'success' => true,
                'message' => 'Dados salvos.',
                'data'    => $pessoa->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

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

            if ($request->wantsJson()) {
                return response()->json($response);
            }

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
        $pessoa = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $pessoa,
            ]);
        }

        return view('pessoas.show', compact('pessoa'));
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
        $pessoa = $this->repository->find($id);

        return view('pessoas.edit', compact('pessoa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PessoasUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PessoasUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $pessoa = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Pessoas updated.',
                'data'    => $pessoa->toArray(),
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
                'message' => 'Pessoas deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Pessoas deleted.');
    }
}
