##x = int(input("Please enter an integer: "))
##
##if x < 0:
##    x = 0
##    print('Negative changed to zero')
##elif x == 0:
##    print('Zero')
##elif x == 1:
##    print('Single')
##elif x == 2:
##    print('ddd')
##else:
##    print('More')
##
##if x > 0:
##    print("pos")
##    if x == 0:
##        print(0)
##    else:
##        print("non 0")
##else:
##    print("neg")

##words = ['cat', 'window', 'defenestrate']
##for w in words:
##    print(w, len(w))

##users = {'Hans': 'active', 'Eleonore': 'inactive', 'IGE': 'active'}
##
##print(users)
##
##for user, status in users.copy().items():
##    if status == 'inactive':
##        del users[user]
##
##print(users)
##
##active_users = {}
##for user, status in users.items():
##    if status == 'active':
##        active_users[user] = status
##
##print(active_users)

##print(list(range(5, 10)))
##print(list(range(0, 10, 3)))
##print(list(range(-10, -100, -30)))

##a = ['Mary', 'had', 'a', 'little', 'lamb']
##for i in range(len(a)):
##    print(i, a[i])

##print(sum(range(4)))


##for n in range(2, 10):
##    for x in range(2, n):
##        print(x)
####        if n % x == 0:
####            print(n, 'equals', x, '*', n // x)
####            break
##    else:
##        print(n, 'is a prime number')
##    print("")

##while True:
##    pass
##
##a = 200

def http_error(status):
    match status:
        case 400:
            return "Bad request"
        case 404:
            return "Not found"
        case 418:
            return "I'm a teapot"
        case _:
            return "Something's wrong with the internet"

##print(http_error(400))
##print(http_error(401))

##for err in range(400, 420):
##    print(err, http_error(err))

##point = (45, 23, 87)

##point = (45, 23)
##
##match point:
##    case (0, 0):
##        print("Origin")
##    case (0, y):
##        print(f"Y = {y}")
##    case (x, 0):
##        print(f"X = {x}")
##    case (x, y):
##        print(f"X = {x}, Y = {y}")
##    case _:
##        raise ValueError("Not a point")
##
##(a, b) = point
##
##print(a, b)

class Point:
    x: int
    y: int

##def where_is(point):
##    match point:
##        case Point(x = 0, y = 0):
##            print("Origin")
##        case Point(x=0, y=y):
##            print(f"Y={y}")
##        case Point(x=x, y=0):
##            print(f"X={x}")
##        case Point():
##            print("Somewhere else")
##        case _:
##            print("Not a point")
##
####abc = Point(x=3, y=4)
##
####where_is(abc)
##    
##
##abc = Point()
##abc.x = 34
##abc.y = 56
##
####print(abc == Point(x=34, y=56))
##print(abc)
##where_is(abc)

##points
##
##match points:
##    case []:
##        print("No points")
##    case [Point(0, 0)]:
##        print("The origin")
##    case [Point(x, y)]:
##        print(f"Single point {x}, {y}")
##    case [Point(0, y1), Point(0, y2)]:
##        print(f"Two on the Y axis at {y1}, {y2}")
##    case _:
##        print("Something else")

##lst = [1, 2, 3]
##lst1 = [1, 2]
##lst2 = [1, 3]
##lst3 = [1, 3, 6]
##
##for lst in [lst1, lst2, lst3]:
##    match lst:
##        case []:
##            print(f"Empty")
##        case [x]:
##            print(f"One el: {x}")
##        case [x, 2]:
##            print(f"Two els*: {x}, {lst[1]}")
##        case [x, y]:
##            print(f"Two els: {x}, {y}")
##        case [x, y, z]:
##            print(f"Three els: {x}, {y}, {z}")
##        case _:
##            print(f"Something else")
##

##point = (3, 4)
##
##match point:
##    case (x, y) if x == y:
##        print(f"Y=X at {x}")
####    case (x, y):
####        print(f"Not on the diagonal")
##
##z = x + y
##
##print(z)


##points = list(range(5))
##
##match points:
##    case []:
##        print("Empty")
##    case [x]:
##        print("1 el")
##    case [x, y]:
##        print("2 els")
####    case [x, y, *rest]:
##    case [x, y, *_]:
##        print("More than 2 els")
##        print(x)
##        print(y)
####        print(rest)
####        print(_)
##    case _:
##        print("_")
##
##

##patts = {"bandwidth": 123, "latency": 67}
##
##match patts:
##    case "":
##        print("{}")
##    case [x, y]:
##        print("Band")
##    case _:
##        print("_")
##

##from enum import Enum
##
##class Color(Enum):
##    RED = 'red'
##    GREEN = 'green'
##    BLUE = 'blue'
##
####color = Color('red')
##color = Color(Color.RED)
##
##match color:
##    case Color.RED:
##        print("I see red!")
##    case Color.GREEN:
##        print("Grass is green")
##    case Color.BLUE:
##        print("I'm feeling the blues:(")
##

def fib(n):
    """Print a Fibonacci series up to n."""
    a, b = 0, 1
    while a < n:
        print(a, end=' ')
        a, b = b, a+b
    print()

##fib(10)
##print(fib)
##f = fib
##f(100)

def fib2(n):
    """Return a list containing the Fibonacci series up to n."""
    result = []
    a, b = 0, 1
    while a < n:
        result.append(a)
        a, b = b, a+b
    return result

##f100 = fib2(100)
##print(f100)



def tmp(a):
    a = a * 2
    return

##print(tmp(345))

res = [1, 2, 3]
res = res + [6]

print(res)
