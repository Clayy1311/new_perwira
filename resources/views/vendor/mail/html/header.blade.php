@props(['url'])
<tr>
  <td class="header" style="text-align: center;">
    <a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
      @if (trim($slot) === 'Laravel')
        <span style="font-size: 28px; font-weight: bold; color: #333;">Perwira Crypto</span>
      @else
        {!! $slot !!}
      @endif
    </a>
  </td>
</tr>
