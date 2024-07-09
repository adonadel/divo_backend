<?php

namespace App\Http\Controllers;


use App\Http\Services\Establishment\CreateEstablishmentService;
use App\Http\Services\Establishment\DeleteEstablishmentService;
use App\Http\Services\Establishment\QueryEstablishmentService;
use App\Http\Services\Establishment\UpdateEstablishmentService;
use App\Rules\ValidateCpfCnpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstablishmentController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|int|exists:users,id',
                'category_id' => 'required|int|exists:categories,id',
                'name' => 'required|string',
                'description' => 'nullable|string',
                'cnpj' => [
                    'required',
                    'string',
                    new ValidateCpfCnpj()
                ],
                'opening_start' => 'required|string',
                'opening_close' => 'required|string',
                'address' => 'nullable|array',
                'address.id' => 'nullable|int',
                'address.zip' => 'required|string',
                'address.street' => 'required|string',
                'address.number' => 'nullable|string',
                'address.neighborhood' => 'nullable|string',
                'address.city' => 'nullable|string',
                'address.state' => 'nullable|string',
                'address.complement' => 'nullable|string',
                'address.longitude' => 'nullable|string',
                'address.latitude' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $service = new CreateEstablishmentService();

            $establishment = $service->create($validated);

            DB::commit();

            return $establishment;
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|int|exists:users,id',
                'category_id' => 'required|int|exists:categories,id',
                'name' => 'required|string',
                'description' => 'nullable|string',
                'cnpj' => [
                    'required',
                    'string',
                    new ValidateCpfCnpj()

                ],
                'opening_start' => 'required|string',
                'opening_close' => 'required|string',
                'address' => 'nullable|array',
                'address.id' => 'nullable|int',
                'address.zip' => 'required|string',
                'address.street' => 'required|string',
                'address.number' => 'nullable|string',
                'address.neighborhood' => 'nullable|string',
                'address.city' => 'nullable|string',
                'address.state' => 'nullable|string',
                'address.complement' => 'nullable|string',
                'address.longitude' => 'nullable|string',
                'address.latitude' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $service = new UpdateEstablishmentService();

            $updated = $service->update($validated, $id);

            DB::commit();

            return $updated;
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            DB::beginTransaction();

            $service = new DeleteEstablishmentService();

            $service->delete($id);

            DB::commit();

            return response()->json([
                'message' => 'Estabelecimento excluído com sucesso!'
            ]);
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }

    public function getEstablishments(Request $request)
    {
        $service = new QueryEstablishmentService();

        return $service->getEstablishments($request->all());
    }

    public function getEstablishmentById(int $id)
    {
        $service = new QueryEstablishmentService();

        return $service->getEstablishmentById($id);
    }
}
