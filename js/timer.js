var Timer;
var TotalSeconds,TotalMins, secs;
var elapsedtime ;

function CreateTimer(TimerID, Time) {
        Timer = document.getElementById(TimerID);
        TotalSeconds = Time;
        elapsedtime = 0
        time = Time
        secs = TotalSeconds%60;
        TotalMins = Math.floor(TotalSeconds/60)
        UpdateTimer()
        window.setTimeout("Tick()", 1000);
}

function Tick() {
if(TotalSeconds-elapsedtime>0)
{
    elapsedtime += 1;
    secs = (elapsedtime%60)-60;
    TotalMins = Math.floor(elapsedtime/60)
    UpdateTimer()
    window.setTimeout("Tick()", 1000);
}
else
alert("time up")
}

function UpdateTimer() {
        Timer.innerHTML = TotalMins + ":" + secs;
}