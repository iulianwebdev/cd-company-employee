<?php

namespace App\Http\Controllers;

use App\Contracts\CompanyStore;
use App\Http\Requests\CreateCompany;
use App\Http\Resources\Company as CompanyResource;
use App\Http\Resources\CompanyCollection as CompaniesResource;
use App\Managers\PublicImageManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    private $store;
    private $imageManager;

    public function __construct(CompanyStore $store, PublicImageManager $imageManager)
    {
        $this->store = $store;
        $this->imageManager = $imageManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCompanies = $this->store->all();

        return new CompaniesResource($allCompanies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompany $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
        ];

        $newCompany = $this->store->create($data);

        $img = $request->file('logo');

        if ($img) {
            $fileName = $this->imageManager->putFile($img, $newCompany->logo_name);

            $this->store->update($newCompany->id, [
                'logo' => $fileName,
                ]);

            $newCompany->logo = $fileName;
        }

        $response = new CompanyResource($newCompany);

        return $response->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CompanyResource($this->store->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCompany $request, $id)
    {
        $existingCompany = $this->store->findOrFail($id);

        $image = $request->file('logo', '');

        $data = $request->toArray();

        if ($image) {
            $newFileName = $this->imageManager->putFile($image, $existingCompany->logo_name);
            $data['logo'] = $newFileName;
        } else {
            unset($data['logo']);
        }
        $updated = $this->store->update($id, $data);

        if ($updated) {
            // dump('gets passed', $data);
            $updatedCompany = $this->store->findOrFail($id);
            // dd($updatedCompany);

            return new CompanyResource($updatedCompany);
        }

        return response(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletedCompany = $this->store->delete($id);

        if ($deletedCompany->exists()) {
            if ($deletedCompany->logo) {
                $fileErased = $this->imageManager->deleteFile($deletedCompany->logo);
                if (!$fileErased) {
                    Log::error("File not erased after company deletion. Filename:{$deletedCompany->logo}");
                }
            }

            return response(Response::HTTP_OK);
        }

        return response(Response::HTTP_BAD_REQUEST);
    }
}
