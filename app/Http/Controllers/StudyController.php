namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function show($id)
    {
        $paper = Paper::findOrFail($id);
        return view('study.show', compact('paper'));
    }
}