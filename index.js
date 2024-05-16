let c, ctx, W, H;
let dots = [];

const random = (max=1, min=0) => Math.random() * (max - min) + min;

class Dot {
    constructor(a){    
        this.x = random(W)
        this.y = random(H)
        this.r = 1.7
        this.s = { x:random(1,-1),y:random(1,-1)}
        this.dir = {x:1,y:1}
    }
    draw() {
        ctx.beginPath()
        ctx.fillStyle = 'white'
        ctx.arc(this.x, this.y, this.r, 0, 3 * Math.PI)
        ctx.fill()
    }
    update() {
        if(this.x>W-this.r||this.x<this.r)this.dir.x*=-1
        if(this.y>H-this.r||this.y<this.r)this.dir.y*=-1
        this.x += this.s.x*this.dir.x
        this.y += this.s.y*this.dir.y
        this.draw()
    }
}

const updateDots = ()=> {
    for(let i=0; i<dots.length; i++){    
        dots[i].update();    
        for(let j=i; j<dots.length; j++){    
            let d = Math.hypot(dots[i].x - dots[j].x,dots[i].y - dots[j].y)
            if(d<60&&i!==j){
                ctx.beginPath()
                ctx.strokeStyle = 'rgba(255,255,255,' + 20/d + ')'
                ctx.lineWidth =  1 
                ctx.moveTo(dots[i].x, dots[i].y);
                ctx.lineTo(dots[j].x, dots[j].y);
                ctx.stroke();
            }        
        }  
    }
}

const init = () => {
    c = document.getElementById("cnv");
    c.width = W = window.innerWidth;
    c.height = H = window.innerHeight;
    ctx = c.getContext("2d");
    for(let i=0;i<100;i++) dots.push(new Dot())
    animate();
};

const animate = () => {
    ctx.clearRect(0, 0, W, H);
    updateDots();
    requestAnimationFrame(animate);
};

onload = init;