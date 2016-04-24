<?php
namespace imer\Marker;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use imer\Marker\Exception\InvalidTypeException;
use imer\Marker\Exception\ValidationException;

class MarkerController extends Controller {
    public function handle(Request $request) {
        try {
            $marker = new Marker($request->input('type'));
        } catch (InvalidTypeException $e) {
            return response()->json(['error' => 'Invalid type']);
        }
        try {
            $values = [];
            if ($request->input('values') && is_array($request->input('values'))) {
                $values = $request->input('values');
            } elseif ($request->input('value') !== null) {
                $values[] = $request->input('value');
            }
            if ($request->input('add')) {
                foreach($values as $value) {
                    $marker->add($value);
                }
            } elseif ($request->input('remove')) {
                foreach($values as $value) {
                    $marker->remove($value);
                }
            } elseif ($request->input('clear')) {
                $marker->clear();
            }
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Invalid value(s)']);
        }
        $marker->save();
        return response()->json(['success' => true, 'dropdown' => $marker->renderDropdown()->render()]);
    }

}