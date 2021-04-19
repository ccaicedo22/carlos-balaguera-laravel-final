php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('carrito') ==false){
            // agregar un flash para avisar q no hay productos en el carrito
           return redirect('producto.index');
        }else {

            $productos = session()->get('carrito.productos');
            return view('components/cart.index',compact('productos'));
        }
     
    }

    public function indiceProductoEnCarrito ($productosActuales,$productoSelected){
            $encontrado = -1;
       
            foreach($productosActuales as $index => $producto) {
                if($producto['producto']->id ==  $productoSelected->id) {
                    $encontrado = $index;
               
                }
             }
            return $encontrado;
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productoSelected = Producto::find($request->productoId);
        $amount = $request->amount; 
        if ($request->session()->has('carrito') ==false){
            $request->session()->put('carrito',['productos'=>[]]);
        }

        //verificacion si existe producto en el carrito

        $productosActuales = $request->session()->get('carrito.productos');
       

        $productoEncontrado = $this->indiceProductoEnCarrito($productosActuales,$productoSelected);




        if ($productoEncontrado != -1) {
            
                    $productosActuales[$productoEncontrado]['cantidad'] += $amount;
                    $request->session()->put('carrito.productos',$productosActuales);
                    $request->session()->flash('status',"se actualizo el carrito de compras");
                    

                    
        }else {
            $request->session()->push('carrito.productos',['producto'=>$productoSelected,'cantidad'=>$amount]);
             $request->session()->flash('status',"se agrego producto al carrito");
        }
        
        return redirect()->route('producto.index');
    }
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

         
        }
}
