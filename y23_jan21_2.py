def ask_ok(prompt, retries=4, reminder='Please try again!'):
    while True:
        ok = input(prompt)
        if ok in ('y', 'ye', 'yes'):
            return True
        if ok in ('n', 'no', 'nop', 'nope'):
            return False
        retries = retries - 1
        if retries < 0:
            raise ValueError('invalid user response')
        print(reminder)

##ask_ok("> ")

##def f(a, L = []):
##    L.append(a)
##    return L
##
##print(f(1))
##print(f(2))
##print(f(3))

def f(a, L = None):
##    if L is None:
##        L = []
    L = []
    L.append(a)
    return L

##print(f(1))
##print(f(2))
##print(f(3))

def parrot(voltage, state='a stiff', action='voom', type='Norwegian Blue'):
    print("-- This parrot wouldn't", action, end=' ')
    print("if you put", voltage, "volts through it.")
    print("-- Lovely plumage, the", type)
    print("-- It's", state, "!")

##parrot(12)
##parrot(12, "STATE", "ACTION", "TYPE")
##parrot(12, action="ACTION", type="TYPE", state="STATE")

def function(a):
    a = a + a
    print(a)
    pass
    pass

##function(34)

def cheeseshop(kind, *args, **keys):
    print("-- Do you have any", kind, "?")
    print("-- I'm sorry, we're all out of", kind)
    for arg in args:
        print(arg)
    else:
        print("___ Out of *args")
    print("-" * 40)
    for kw in keys:
        print(kw, ":", keys[kw])
    else:
        print("___ Out of **keys")

##cheeseshop("Limburger", "It's very runny, sir.",
##           "It's really very, VERY runny, sir.",
##           shopkeeper="Michael Palin",
##           client="John Cleese",
##           sketch="Cheese Shop Sketch")

def foo(a, b, /, c, d, *, e, f):
    print(a, b, "/", c, d, "*", e, f)

##foo(1, 2, 3, d=4, e=5, f=6)

def standard_arg(arg):
    print(arg)

def pos_only_arg(arg, /):
    print(arg)

def kwd_only_arg(*, arg):
    print(arg)

def combined_example(pos, /, std, *, kwd):
    print(pos, std, kwd)

##standard_arg(2)
##standard_arg(arg=2)
##
##pos_only_arg(2)
##pos_only_arg(arg=2)
##
##kwd_only_arg(2)
##kwd_only_arg(arg=2)

def foobar(name, **kwds):
    return 'name' in kwds

##foobar(1, **{"name": "j", "kkk": "k"})

def concat(*args, sep="/"):
    return sep.join(args)

##print(concat("earth", "mars", "venus"))
##print(concat("earth", "mars", "venus", sep="."))

##print(list(range(3, 6)))
##args = [3, 6]
##print(list(range(*args)))
##print(list(range(*[3, 6])))

def make_inc(n):
    return lambda x: x + n

##f = make_inc(42)
####print(f(0))
####print(f(1))
##
##pairs = [(1, 'one'), (2, 'two'), (3, 'three'), (4, 'four')]
##print(pairs)
##print(pairs[1])
##
##pairs.sort(key = lambda pair: pair[1])
##print(pairs)
##

def my_function():
    """Do nothing, but document it.

    No really, it doesn't do anything.
    """
    pass


##print(my_function.__doc__)

def f(ham: str, eggs: str = 'eggs') -> str:
    print("Annotations:", f.__annotations__)
    print("Arguments:", ham, eggs)
    return ham + ' and ' + eggs
##    return ham + eggs

##f('spam')
####f(2, 3)
##
##ąę = 12
##print(ąę)

def tmpfnc(a):
    a = a + [100]

##a = 456
##print(a)
##tmpfnc(a)
##print(a)

##a = [1, 2, 3]
##print(a)
##tmpfnc(a)
##print(a)

##def inc(x):
##    print(f" init address of x: {id(x)}")
##    x += 1
##    print(f"final address of x: {id(x)}")
##
##n = 9001
##print(f" init address of n: {id(n)}")
##inc(n)
##print(f"final address of n: {id(n)}")
##
##print(id(n))

def fed(lst):
    print('got', lst)
##    lst.append('AAA')
    lst = lst + ['aaa']
    print('now', lst)

out_lst = ["111", "222"]

##print("bef", out_lst)
##fed(out_lst)
##print("aft", out_lst)

print(id(out_lst))
out_lst.append("asd")
print(id(out_lst))
out_lst = out_lst + ["ggg"]
print(id(out_lst))

import this
