@extends('user.base')

@section('search')
    <div></div>
@endsection

@section('contenu')

<section class="validated">
    @if ($status == 'approved')
    <div >
        <i class="fa-solid fa-circle-check"></i>
        <p>Félicitation, vous avez éffectué le payement et votre commande est déja prise en compte</p>
        <p>Un mail de confirmation de commande vous a été envoyé </p>
        <a href="{{route('homefood')}}" class="btn">Retour</a>
    </div>
    @endif

    @if ($status == 'declined')
    <div >
        <i class="fa-solid fa-circle-check"></i>
        <p>Désolé, nous avons rencontré un probleme lors du paiement</p>
        <p>Vérifiez votre solde ou la validité de votre compte</p>
        <a href="{{route('homefood')}}" class="btn">Retour</a>
    </div>
    @endif      
</section>
@endsection