/*************************** Question Object ***********************/
function Question(identifier, question, answers, result)
{
    this.ident = identifier;
    this.quest = question;
    this.ans = answers;
    this.result = result;
}

/*************************** Survey Object ***********************/
// constructors for the survey object
function Survey(name, description, questions, numOfPpl)
{
    var nArgs = arguments.length;
    if(nArgs==0||nArgs>4){
        this.name="";
        this.description="";
        this.questions=[];
        this.numOfPpl=0;
    }else if(nArgs==4){
        this.name=name;
        this.description=description;
        this.questions=questions;
        this.numOfPpl=0;
    }else if(nArgs==3){
        this.name=name;
        this.description=description;
        this.questions=questions;
        this.numOfPpl=0;
    }else if(nArgs==2){
        this.name=name;
        this.description=description;
        this.questions=[];
        this.numOfPpl=0;
    }else{
        this.name=name.name;
        this.description=name.description;
        this.questions=name.questions;
        this.numOfPpl=name.numOfPpl;
    }
}

// return the name of the creator
Survey.prototype.getName=function()
{
    return this.name;
};

// return the description
Survey.prototype.getDescription=function()
{
    return this.description;
};

// add a question
Survey.prototype.addQuestion=function(identifier, question, answers)
{
    // initiate the result array
    var resultArr = [0,0,0,0,0];
    for(var i = 0; i < answers.length; i++){
        resultArr[i]=0;
    }
    
    // create an temp question object and push it into the list of questions
    var newQuestion = new Question(identifier, question, answers, resultArr);
    this.questions.push(newQuestion);
};

// display the questions for survey
Survey.prototype.displaySurvey=function()
{
    document.getElementById("survey_name").innerHTML += this.name;
    document.getElementById("description").innerHTML += this.description;

    document.getElementById("main").innerHTML+='<form action="getResult.php?title='+this.name+'" method="post" id="surveyForm"></form>';
    for(var i = 0; i < this.questions.length; i++){
        var curQuest = this.questions[i];
        
        // printing the question
        document.getElementById("surveyForm").innerHTML+="<h4>"+curQuest.ident+". "+curQuest.quest+"</h4>";
        // pringing the answers
        for(var j=0;j<curQuest.ans.length;j++){
            document.getElementById("surveyForm").innerHTML+='<input type="radio" name='+curQuest.ident+" value='"+curQuest.ans[j]+"' required> "+curQuest.ans[j]+"<br><br>";
        }
        
        document.getElementById("surveyForm").innerHTML+="<hr>";
    }
    document.getElementById("surveyForm").innerHTML+='<input type="submit" name="submit" id="surveySubmit">';
};

//display the questions with the results
Survey.prototype.displayResult=function()
{
    document.getElementById("survey_name").innerHTML += this.name;
    document.getElementById("description").innerHTML += this.description;
    
    // Display the result of the survey
    document.getElementById("main").innerHTML+='<div id="resultBigCont"></div>'
    for(var i = 0; i < this.questions.length; i++){
        var curQuest = this.questions[i];
        var resultLoc = "result"+curQuest.ident;
        var color = ['#f47158','#ffc268','#fff67c','#60cc3f', '#59d6b6', '#75c1ff','#a09bff','#fb9bff'];
        
        document.getElementById("resultBigCont").innerHTML+='<div id="'+resultLoc+'" class="resultCont"></div>';
        document.getElementById(resultLoc).innerHTML+="<h4>"+curQuest.ident+". "+curQuest.quest+"</h4>";
        
        // count number of ppl took this question
        var numOfPPL = 0;
        for(var k = 0; k< curQuest.ans.length;k++){
            numOfPPL += curQuest.result[k];
        }
        
        if(numOfPPL == 0){
            document.getElementById(resultLoc).innerHTML+= '<div class="resultChart" style="width:100%; background-color:white;">No Result Recorded</div>';
        }
        
        for(var j=0;j<curQuest.ans.length;j++){
            var width = ((curQuest.result[j])/numOfPPL)*100;
            var colorSelected;
            if(j > 7){
                colorSelected = color[7-j];
            }else{
                colorSelected = color[j];
            }
            
            var idName = "resultChart"+curQuest.ident+j;
            if(curQuest.result[j]!=0){
                var mouseOver = 'showDetail(\''+idName+'\','+curQuest.result[j]+','+width+')';
                var mouseOut = 'hideDetail(\''+idName+'\',\''+curQuest.ans[j]+'\')';
                
                document.getElementById(resultLoc).innerHTML+= '<div id="'+idName+'" class="resultChart" style="width:'+width+'%; background-color:'+colorSelected+';" onmouseover="'+mouseOver+'" onmouseout="'+mouseOut+'">'+curQuest.ans[j]+'</div>';
            }
        }
        
        document.getElementById(resultLoc).innerHTML+="<hr>";
    }
};

function showDetail(idLoc, result, percent){
    document.getElementById(idLoc).innerHTML = result + " - " + percent + "%";
}

function hideDetail(idLoc, ans){
    document.getElementById(idLoc).innerHTML = ans;
}