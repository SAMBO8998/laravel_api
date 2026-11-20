<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Check_role
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->user();
        if(!$user){
            return response()->json([
                'success'   =>false,
                'message'   =>'not allow',
            ],401);
        }
        if($user->role !== $role){
            return response()->json([
                'success'   => false,
                'message'   => 'You do not have permission',
            ], 403);
        }
        return $next($request);
    }
}