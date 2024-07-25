<p><strong>Follow us on</strong></p>

   <p>
        {{-- <a href="http://www.facebook.com/pages/New-Mangalore-Port-Trust/1601939813389904"rel="" target="_blank" title="">
        <img alt="Facebook" data-entity-type="file" data-entity-uuid="400ba506-f5b4-4ced-bd3e-bb6887ac8542" src="./sites/default/files/inline-images/facebook.png" class="align-left" width="64" height="64" loading="lazy" /></a><a href="https://twitter.com/NewMngPort" rel="" target="_blank" title="">
        <img alt="Twitter" data-entity-type="file" data-entity-uuid="063b4bdf-7bce-4b53-a144-62a1d661d570" src="./sites/default/files/inline-images/twitter.png" class="align-left" width="64" height="64" loading="lazy" /></a>
        <a href="https://www.youtube.com/channel/UCz9fdx_BlvJLTrwVMA5oXuA" rel="" target="_blank" title=""><img alt="Youtube" data-entity-type="file" data-entity-uuid="0a1b8c69-e1c9-49d2-b003-ff727a338f84" src="./sites/default/files/inline-images/youtube.png" class="align-left" width="64" height="64" loading="lazy" /></a> --}}
  @foreach ($socialmedia as $socialmedias)
  <a href="#"rel="" target="_blank" title="">
  <img alt="Facebook" data-entity-type="file" data-entity-uuid="400ba506-f5b4-4ced-bd3e-bb6887ac8542" src="{{ asset('/assets/backend/uploads/Linkicon/'.$socialmedias->file) }}" class="align-left" width="64" height="64" loading="lazy" /></a><a href="https://twitter.com/NewMngPort" rel="" target="_blank" title="">
  </a>
  @endforeach

    </p>
