<div>
    <div style="text-align: center; margin-bottom: 10px;">
        <span style="font-weight: bold; font-size: 16px;">Progresso da Avaliação de Qualidade</span>
    </div>
    <div class="progress" style="height: 30px; background-color: #f3f3f3; border-radius: 15px; overflow: hidden; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); position: relative;">
        <div class="progress-bar" role="progressbar" style="width: {{$progress}}%; 
            background-image: linear-gradient(to right, 
                {{$progress >= 90 ? '#4caf50, #4caf50' : 
                    ($progress >= 80 ? '#689f38, #689f38' : 
                        ($progress >= 70 ? '#8bc34a, #8bc34a' : 
                            ($progress >= 60 ? '#a4b42b, #a4b42b' : 
                                ($progress >= 50 ? '#cddc39, #cddc39' : 
                                    ($progress >= 40 ? '#fbc02d, #fbc02d' : 
                                        ($progress >= 30 ? '#ffeb3b, #ffeb3b' : 
                                            ($progress >= 20 ? '#ffc107, #ffc107' : 
                                                ($progress >= 10 ? '#ff9800, #ff9800' : '#f44336, #f44336')
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                }}); 
            border-radius: 15px; 
            box-shadow: 0 3px 3px -5px rgba(0, 0, 0, 0.1), 0 2px 5px 
                {{$progress >= 90 ? '#4caf50' : 
                    ($progress >= 80 ? '#689f38' : 
                        ($progress >= 70 ? '#8bc34a' : 
                            ($progress >= 60 ? '#a4b42b' : 
                                ($progress >= 50 ? '#cddc39' : 
                                    ($progress >= 40 ? '#fbc02d' : 
                                        ($progress >= 30 ? '#ffeb3b' : 
                                            ($progress >= 20 ? '#ffc107' : 
                                                ($progress >= 10 ? '#ff9800' : '#f44336')
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                }};
            " 
            aria-valuenow="{{$progress}}" 
            aria-valuemin="0" 
            aria-valuemax="100">
            <span style="color: #fff; font-weight: bold; font-size: 14px; position: absolute; top: 50%; transform: translateY(-50%); left: 5px;">{{$progress}}%</span>
        </div>
    </div>
</div>
