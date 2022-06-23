<x-layout>
    <main>
        <h1 id='title' style="color: {{ $aAllPlayers['team_color'] }}">{{ $aAllPlayers['title'] }}</h1>
            <span style='position:absolute; right:0' class="float-right">
                @foreach ($aAllPlayers as $aRowTwo)
                    @if (is_array($aRowTwo) === false)
                        @continue
                    @endif
                    <a href="#" class="float-right player-list" data-playerselection='{{ "card_" . $aRowTwo["id"] }}'>{{ $aRowTwo['first_name'] }}</a>
                @endforeach
            </span>
            @foreach ($aAllPlayers as $aRow)   
                @if (is_array($aRow) === false)
                    @continue
                @endif
                
                @if ($loop->first)
                    <div class="card player-cards" id='{{ "card_" . $aRow["id"] }}' style="border-top: solid 0.75rem {{ $aRow['team_color'] }}">
                @else
                    <div class="card player-cards" id='{{ "card_" . $aRow["id"] }}' style="border-top: solid 0.75rem {{ $aRow['team_color'] }}; display: none">
                @endif            
                
                    <img src="{{ $aRow['team_logo'] }}" alt="{{ $aRow['team_logo'] }}" class="logo" />
                    <div class="name">
                        <em>#{{ $aRow['number'] }}</em>
                        <h2>{{ $aRow['first_name'] }} <strong>{{ $aRow['last_name'] }}</strong></h2>
                    </div>
                    <div class="profile">
                        <img src="{{ $aRow['image'] }}" alt="{{ $aRow['first_name'] }} {{ $aRow['last_name'] }}" class="headshot" />
                        <div class="features">
                            @foreach ($aRow['featured'] as $statistic)
                                <div class="feature">
                                    <h3>{{ $statistic['label'] }}</h3>
                                    {{ $statistic['value'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bio">
                        <div class="data">
                            <strong>Position</strong>
                            {{ $aRow['position'] }}
                        </div>
                        <div class="data">
                            <strong>Weight</strong>
                            {{ $aRow['weight'] }}KG
                        </div>
                        <div class="data">
                            <strong>Height</strong>
                            {{ $aRow['height'] }}
                        </div>
                        <div class="data">
                            <strong>Age</strong>
                            {{ $aRow['age'] }} years
                        </div>
                    </div>
                    
                </div>
                
            @endforeach
        
    </main>
</x-layout>
