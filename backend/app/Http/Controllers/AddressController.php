<?php

namespace App\Http\Controllers;

use App\Models\AddressesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    private function validateAddress(Request $request): array
    {
        return Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|min:8|max:30',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'address_line' => 'required|string',
            'is_default' => 'sometimes|boolean',
        ])->validate();
    }

    public function store(Request $request)
    {
        $this->authorize('create', AddressesModel::class);

        $validated = $this->validateAddress($request);
        $userId = $request->user()->role?->name === 'admin' && $request->filled('user_id')
            ? (int) $request->user_id
            : (int) $request->user()->id;

        $address = AddressesModel::create([
            ...$validated,
            'user_id' => $userId,
            'is_default' => (bool) ($validated['is_default'] ?? false),
        ]);

        return $this->successResponse('Address created successfully.', [
            'address' => $address,
        ], 201);
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', AddressesModel::class);

        $query = AddressesModel::query()->latest();

        if ($request->user()->role?->name !== 'admin') {
            $query->where('user_id', $request->user()->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        return $this->successResponse('Addresses found.', [
            'addresses' => $query->get(),
        ]);
    }

    public function show(Request $request, $id)
    {
        $address = AddressesModel::find($id);

        if (!$address) {
            return $this->errorResponse('Address not found.', 404);
        }

        $this->authorize('view', $address);

        return $this->successResponse('Address found.', [
            'address' => $address,
        ]);
    }

    public function update(Request $request, $id)
    {
        $address = AddressesModel::find($id);

        if (!$address) {
            return $this->errorResponse('Address not found.', 404);
        }

        $this->authorize('update', $address);

        $validated = $this->validateAddress($request);

        $address->update([
            ...$validated,
            'user_id' => $address->user_id,
            'is_default' => (bool) ($validated['is_default'] ?? $address->is_default),
        ]);

        return $this->successResponse('Address updated successfully.', [
            'address' => $address->fresh(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $address = AddressesModel::find($id);

        if (!$address) {
            return $this->errorResponse('Address not found.', 404);
        }

        $this->authorize('delete', $address);
        $address->delete();

        return $this->successResponse('Address deleted successfully.', [
            'address' => $address,
        ]);
    }
}
